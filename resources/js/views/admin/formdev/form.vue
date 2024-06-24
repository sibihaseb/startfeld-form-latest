<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button v-if="!isVisible" type="primary" @click="toggleFormSection"
          >Add Questions</el-button
        >
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
          <form-build
            @edit="editQuestion"
            :allQuestions="allQuestions"
            :steps="steps"
          ></form-build>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, Ref } from "vue";
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

const editQuestion = (singleQuestion: QuestionCreate) => {
  console.log(singleQuestion);
};
const onSubmit = (createdQuestion: QuestionCreate) => {
  if (createdQuestion.step > steps.value.totalStep.length) {
    if (createdQuestion.total_section) {
      steps.value.totalStep = createdQuestion.total_section;
    }
  }
  steps.value.activeStepNo = createdQuestion.step;
  allQuestions.value.push(createdQuestion);
  toggleFormSection();
};
</script>
