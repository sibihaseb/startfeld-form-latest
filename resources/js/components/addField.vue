<template>
  <div class="add-field">
    <el-form
      :model="form"
      label-width="auto"
      label-position="top"
      ref="createForm"
      :rules="rules"
      require-asterisk-position="right"
    >
      <el-form-item label="Title" class="error-space" prop="title">
        <el-input v-model="form.title.value" type="text" />
      </el-form-item>
      <el-form-item label="Description" class="error-space" prop="description">
        <el-input v-model="form.description.value" type="text" />
      </el-form-item>
      <el-form-item label="Type" class="error-space" prop="answer_type">
        <el-select
          v-model="form.answer_type"
          @change="formoption"
          placeholder="Please select field type"
        >
          <el-option
            v-for="(type, index) in QuestionAnswerType"
            :key="index"
            :label="type"
            :value="type"
          />
        </el-select>
      </el-form-item>

      <!-- Dynamic Field for options -->
      <div v-if="createStepState.addoption">
        <el-button type="primary" @click="addOption">Add Options</el-button>
        <el-form-item class="margin-add-opt">
          <div v-for="(option, index) in options" :key="index" class="flex-add-column">
            <el-input
              v-model="option.value"
              placeholder="Enter option"
              type="text"
            ></el-input>
            <i
              class="ri-delete-bin-line ri-lg icon-margin"
              @click="removeOption(index)"
            ></i>
          </div>
        </el-form-item>
      </div>

      <el-form-item label="Steps" class="error-space">
        <el-select v-model="form.step" placeholder="Please select steps">
          <el-option
            v-for="item in createStepState.totalSections"
            :key="item"
            :label="'Section ' + item"
            :value="item"
            >{{ "Section " + item }}
            {{ item > createStepState.totalLength ? " (New)" : "" }}</el-option
          >
        </el-select>
      </el-form-item>

      <el-form-item label="Is Mandatory">
        <el-radio-group v-model="form.is_mandatory" id="isMandatory" class="ml-4">
          <el-radio :label="true">True</el-radio>
          <el-radio :label="false">False</el-radio>
        </el-radio-group>
      </el-form-item>

      <!-- Additional fields based on selected type -->
      <el-form-item>
        <el-button type="primary" @click="onSubmit(createForm)">Save</el-button>
        <el-button @click="cancelSection">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script setup lang="ts" name="addField">
import { onMounted, ref, Ref, reactive, defineProps, PropType } from "vue";
import type { QuestionCreate, QuestionValueOption } from "../client/index";
import { QuestionAnswerType } from "../client/models/QuestionAnswerType";
import type { FormInstance, FormRules } from "element-plus";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
const createForm = ref<FormInstance>();
const props = defineProps({
  editQuestion: {
    required: false,
    type: Object || undefined,
    default: () => {},
  },
  steps: {
    required: true,
    type: Array || undefined,
    default: () => [],
  },
});

const emit = defineEmits(["submit", "cancel"]);

const createStepState = reactive({
  errorMsg: "",
  loading: false,
  totalLength: 0,
  totalSections: <number[]>[],
  addoption: false,
  adddescription: false,
  newSection: true,
});

const form: Ref<QuestionCreate> = ref({
  id: 1,
  step: 1,
  sort_order: 0,
  title: {
    value: "",
    name: { en: "" },
  },
  description: {
    value: "",
    name: { en: "" },
  },
  answer_type: QuestionAnswerType.title,
  is_mandatory: false,
});

const options: Ref<QuestionValueOption[]> = ref([
  {
    value: "",
    name: "",
  },
]);

const cancelSection = () => {
  emit("cancel");
};

const addOption = () => {
  options.value.push({ value: "", name: "" });
};
const removeOption = (index) => {
  options.value.splice(index, 1);
};

const onSubmit = (formEl: FormInstance | undefined) => {
  if (!formEl) {
    return;
  }
  formEl.validate((valid) => {
    if (valid) {
      if (options) {
        form.value.options = {};
        options.value.forEach((option: QuestionValueOption) => {
          option.name = {
            en: option.value,
            de: option.value,
          };
        });
        form.value.options.values = options.value;
      }
      form.value.title.name.en = form.value.title.value;
      form.value.description.name.en = form.value.description.value;
      form.value.total_section = createStepState.totalSections;
      emit("submit", { ...form.value });
    }
  });
};

onMounted(() => {
  getAllPaths();
});

const getAllPaths = () => {
  if (props.editQuestion) {
    let currentEditQuestion = props.editQuestion.editQuestion;
    if (currentEditQuestion !== undefined) {
      form.value = currentEditQuestion;
    }
  }
  let steps = props.steps;
  createStepState.totalLength = steps.length;
  if (createStepState.totalLength === 0) {
    createStepState.totalSections.push(1);
  } else {
    for (let i = 1; i <= createStepState.totalLength + 1; i++) {
      createStepState.totalSections.push(i);
      form.value.step = i == 1 ? 1 : i - 1;
    }
  }
};

const rules = reactive<FormRules>({
  step: [
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],
  title: [
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],

  description: [
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],

  answer_type: [
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],
});

const formoption = (questionType: QuestionAnswerType) => {
  if (
    questionType === QuestionAnswerType.radio ||
    questionType === QuestionAnswerType.checkbox ||
    questionType === QuestionAnswerType.dropdown
  ) {
    createStepState.addoption = true;
  } else if (
    questionType === QuestionAnswerType.text ||
    questionType === QuestionAnswerType.textarea ||
    questionType === QuestionAnswerType.date ||
    questionType === QuestionAnswerType.file ||
    questionType === QuestionAnswerType.number ||
    questionType === QuestionAnswerType.title
  ) {
    createStepState.addoption = false;
  }
};
</script>

<style lang="scss" scoped>
@use "../assets/scss/colors" as *;
.add-field {
  margin-top: 20px;
  margin-bottom: 20px;
}

.flex-add-column {
  display: flex;
  min-width: 100%;
  gap: 16px;
  justify-content: center;
  align-items: center;
  margin-top: 10px;
  margin-bottom: 10px;
}

.icon-margin {
  color: $error;
}
</style>
