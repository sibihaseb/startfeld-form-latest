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
              :editQuestion="questionEdit"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></add-field>
          </div>
        </div>

        <div v-if="!isVisible">
          <form-build
            @edit="emitQuestionEdit"
            @delete="deleteQuestionArray"
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
const questionEdit: Ref<QuestionCreate | undefined> = ref();
const isVisible = ref(false);
const editQuestionCheck = ref(false);
const steps = ref<StepCreate>({
  activeStepNo: 1,
  totalStep: [1],
});

const toggleFormSection = () => {
  isVisible.value = !isVisible.value;
};

const emitQuestionEdit = (singleQuestion: QuestionCreate) => {
  questionEdit.value = singleQuestion;
  editQuestionCheck.value = true;
  toggleFormSection();
};

const onSubmit = (createdQuestion: QuestionCreate) => {
  console.log(createdQuestion.id, allQuestions.value.length);
  if (createdQuestion.id) {
    if (editQuestionCheck.value) {
      editQuestionCheck.value = false;
      questionEdit.value = undefined;
    }
    updateQuestionArray(createdQuestion);
    if (createdQuestion.step > steps.value.totalStep.length) {
      if (createdQuestion.total_section) {
        steps.value.totalStep = createdQuestion.total_section;
      }
    }
    steps.value.activeStepNo = createdQuestion.step;
    if (createdQuestion.id === 1) {
      createdQuestion.id = allQuestions.value.length + 1;
    }
    toggleFormSection();
  }
};

// Function to handle the question insertion
function updateQuestionArray(createdQuestion: QuestionCreate) {
  // Find the index of the createdQuestion in the array
  const index = allQuestions.value.findIndex((q) => q.id === createdQuestion.id);

  // If the question is found, remove it
  if (index !== -1) {
    allQuestions.value.splice(index, 1);
  }

  // Add the createdQuestion to the array
  allQuestions.value.push(createdQuestion);
}

function deleteQuestionArray(createdQuestion: QuestionCreate) {
  // Find the index of the createdQuestion in the array
  const index = allQuestions.value.findIndex((q) => q.id === createdQuestion.id);

  // If the question is found, remove it
  if (index !== -1) {
    allQuestions.value.splice(index, 1);
  }
}
</script>
