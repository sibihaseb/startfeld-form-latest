<template>
  <div class="applicant">
    <el-form :model="form" label-width="auto">
      <el-form-item label="Title">
        <el-input v-model="form.title.value" />
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="form.description.value" />
      </el-form-item>
      <el-form-item label="Type">
        <el-select v-model="form.answer_type" placeholder="Please select field type">
          <el-option
            v-for="(type, index) in QuestionAnswerType"
            :key="index"
            :label="type"
            :value="type"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="Steps">
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
        <el-button type="primary" @click="onSubmit">Save</el-button>
        <el-button @click="cancelSection">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script setup lang="ts" name="addField">
import { onMounted, ref, Ref, reactive, defineProps } from "vue";
import type { QuestionCreate, StepCreate } from "../client/index";
import { QuestionAnswerType } from "../client/models/QuestionAnswerType";

const props = defineProps({
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
  addbutton: false,
  newSection: true,
});

const form: Ref<QuestionCreate> = ref({
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
const cancelSection = () => {
  emit("cancel");
};

const onSubmit = () => {
  form.value.title.name.en = form.value.title.value;
  form.value.description.name.en = form.value.description.value;
  form.value.total_section = createStepState.totalSections;
  emit("submit", { ...form.value });
};

onMounted(() => {
  getAllPaths();
});

const getAllPaths = () => {
  let steps = props.steps;
  //   allQuestions = Object.keys(allQuestions).map((field) => {
  //     return {
  //       name: "Section " + field,
  //       Step: steps[field],
  //     };
  //   });

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
</script>
