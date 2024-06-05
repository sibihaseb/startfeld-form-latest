<template>
  <div class="applicant">
    <el-form :model="form" label-width="auto">
      <el-form-item label="Title">
        <el-input v-model="form.title" />
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="form.description" />
      </el-form-item>
      <el-form-item label="Type">
        <el-select
          v-model="form.answer_type"
          placeholder="Please select field type"
        >
          <el-option label="Text" value="text" />
          <el-option label="Radio" value="radio" />
          <el-option label="Checkbox" value="checkbox" />
          <el-option label="Number" value="number" />
          <el-option label="Email" value="email" />
          <el-option label="Date" value="date" />
          <el-option label="URL" value="url" />
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
        <el-radio-group
          v-model="form.is_mandatory"
          id="isMandatory"
          class="ml-4"
        >
          <el-radio :label="true">True</el-radio>
          <el-radio :label="false">False</el-radio>
        </el-radio-group>
      </el-form-item>

      <!-- Additional fields based on selected type -->
      <template
        v-if="form.answer_type === 'radio' || form.answer_type === 'checkbox'"
      >
        <el-form-item label="Options">
          <el-input
            v-model="form.options"
            placeholder="Enter options separated by commas"
          />
        </el-form-item>
      </template>
      <template v-if="form.answer_type === 'number'">
        <el-form-item label="Min Value">
          <el-input v-model="form.minValue" placeholder="Enter minimum value" />
        </el-form-item>
        <el-form-item label="Max Value">
          <el-input v-model="form.maxValue" placeholder="Enter maximum value" />
        </el-form-item>
      </template>
      <template v-if="form.answer_type === 'date'">
        <el-form-item label="Date Format">
          <div class="demo-datetime-picker">
            <div class="block">
              <el-date-picker
                v-model="dateTime"
                type="datetime"
                placeholder="Pick a Date"
                format="YYYY/MM/DD HH:mm:ss"
              />
            </div>
          </div>
        </el-form-item>
      </template>
      <template v-if="form.answer_type === 'url'">
        <el-form-item label="Protocol">
          <el-input v-model="form.protocol" placeholder="Enter protocol" />
        </el-form-item>
      </template>

      <el-form-item>
        <el-button type="primary" @click="onSubmit">Save</el-button>
        <el-button @click="cancelSection">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script setup lang="ts" name="addField">
import { ref,Ref } from "vue";
import { defineProps } from "vue";
import type { QuestionCreate } from "../client/index";

const props = defineProps<{ step: any[] }>();
const emit = defineEmits();
const dateTime = ref("");
const form : Ref<QuestionCreate> = ref({
  title: "",
  description: "",
  answer_type: "",
  step: "",
  is_mandatory: true,
});
const cancelSection = () => {
  emit("cancel");
};
const initialSubmissions = ref<number>(2);
const currentStep = ref<number>(1);

const onSubmit = () => {
  console.log("submit!");
  form.value.step = currentStep.value; // Set the step value
  emit("submit", { ...form.value });
  if (initialSubmissions.value > 0) {
    initialSubmissions.value--; // Decrement initialSubmissions for the first two times
  } else {
    currentStep.value++; // Increment step for subsequent submissions
  }
};
</script>
