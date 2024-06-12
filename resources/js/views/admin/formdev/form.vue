<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button type="primary" @click="toggleFormSection">Add Questions</el-button>
        <div v-if="isVisible">
          <div class="section">
            <add-field
              :steps="steps.totalStep"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></add-field>
          </div>
        </div>

        <div v-if="!isVisible">
          <form-build :allQuestions="allQuestions" :steps="steps"></form-build>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, Ref, toRaw } from "vue";
import AddField from "@/components/addField.vue";
import formBuild from "@/components/formBuild.vue";
import type { QuestionCreate, StepCreate } from "../../../client/index";

const allQuestions: Ref<QuestionCreate[]> = ref([]);

const isVisible = ref(false);
const steps = ref<StepCreate>({
  activeStepNo: 1,
  totalStep: [1],
});

const toggleFormSection = () => {
  isVisible.value = !isVisible.value;
};
const onSubmit = (form: QuestionCreate) => {
  //   if (form.step > steps.value.totalStep) {
  console.log(form.step);
  console.log(steps.value.totalStep.length);
  if (form.step > steps.value.totalStep.length) {
    if (form.total_section) {
      console.log(form.total_section);
      steps.value.totalStep = form.total_section;
    }
  }
  steps.value.activeStepNo = form.step;
  //   }
  allQuestions.value.push(form);
  toggleFormSection();
};
</script>
