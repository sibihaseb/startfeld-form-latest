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
        <el-select v-model="currentStep" placeholder="Please select steps">
          <el-option
            v-for="(section, index) in props.step"
            :key="index"
            :label="`Step ${index + 1}`"
            :value="index + 1"
          />
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
import { ref, Ref, defineProps } from "vue";
import type { QuestionCreate } from "../client/index";
import { QuestionAnswerType } from "../client/models/QuestionAnswerType";

const props = defineProps<{
  step: number;
  sort_order: number;
}>();

const emit = defineEmits();

const form: Ref<QuestionCreate> = ref({
  step: props.step,
  sort_order: props.sort_order,
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
const initialSubmissions = ref<number>(2);
const currentStep = ref<number>(1);

const onSubmit = () => {
  console.log("submit!");
  form.value.title.name.en = form.value.title.value;
  form.value.description.name.en = form.value.description.value;
  form.value.step = currentStep.value; // Set the step value
  emit("submit", { ...form.value });

  if (initialSubmissions.value > 0) {
    initialSubmissions.value--; // Decrement initialSubmissions for the first two times
  } else {
    currentStep.value++; // Increment step for subsequent submissions
  }
};
</script>
