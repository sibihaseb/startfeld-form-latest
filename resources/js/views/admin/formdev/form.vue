<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4" v-if="!isDelete">
        <div class="form-header">
          <el-button v-if="!isVisible" type="primary" @click="toggleFormSection"
            >Add Questions</el-button
          >
          <el-button
            v-if="!isVisible && allQuestions.length > 0"
            type="success"
            :loading="createFormState.loading"
            @click="submitQuestions"
            >Save Questions</el-button
          >
        </div>
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
      <div class="mb-4 delete-div" v-if="isDelete">
        <div class="delete-dialog">
          <h3>Are you Sure you want to Delete?</h3>
          <div class="space-div">
            <el-button type="primary" @click="deleteArrayData">Ok</el-button>
            <el-button type="danger" @click="cancleDetele">Cancle</el-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, Ref, reactive } from "vue";
import AddField from "@/components/addField.vue";
import formBuild from "@/components/formBuild.vue";
import type { QuestionCreate, StepCreate } from "../../../client/index";
import { questionService } from "../../../client/services/questionService";
import { useI18n } from "vue-i18n";

const i18nLocale = useI18n();
const allQuestions: Ref<QuestionCreate[]> = ref([]);
const questionEdit: Ref<QuestionCreate | undefined> = ref();
const questionDelete: Ref<QuestionCreate | undefined> = ref();
const isVisible = ref(false);
const isDelete = ref(false);
const editQuestionCheck = ref(false);
const steps = ref<StepCreate>({
  activeStepNo: 1,
  totalStep: [1],
});

const createFormState = reactive({
  errorMsg: "",
  loading: false,
});

const toggleFormSection = () => {
  isVisible.value = !isVisible.value;
};

const toggleDeleteSection = () => {
  isDelete.value = !isDelete.value;
};

const emitQuestionEdit = (singleQuestion: QuestionCreate) => {
  questionEdit.value = singleQuestion;
  editQuestionCheck.value = true;
  toggleFormSection();
};

const onSubmit = (createdQuestion: QuestionCreate) => {
  console.log(createdQuestion.id, allQuestions.value);
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

function deleteArrayData() {
  console.log(questionDelete.value);
  if (questionDelete.value !== undefined) {
    if (questionDelete.value.id !== undefined) {
      const index = allQuestions.value.findIndex(
        (q) => q.id === questionDelete.value?.id
      );
      console.log(index, allQuestions.value);
      allQuestions.value.splice(index, 1);
      questionDelete.value = undefined;
      toggleDeleteSection();
    }
  }
}

function deleteQuestionArray(createdQuestion: QuestionCreate) {
  // Find the index of the createdQuestion in the array
  questionDelete.value = createdQuestion;
  toggleDeleteSection();
}

function cancleDetele() {
  questionDelete.value = undefined;
  toggleDeleteSection();
}

const submitQuestions = async () => {
  let formData = new FormData();
  formData.append("questions", JSON.stringify(allQuestions.value));
  if (allQuestions.value.length > 0) {
    await questionService
      .create(formData, i18nLocale.locale.value)
      .then((questions: QuestionCreate[]) => {
        allQuestions.value = questions;
      })
      .catch((error) => {
        createFormState.errorMsg = error.data.message;
      });
  }
};
</script>
<style lang="scss" scoped>
.delete-div {
  display: flex;
  justify-content: center;
}
.delete-dialog {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.space-div {
  margin-top: 20px;
}

.form-header {
  display: flex;
  justify-content: space-between;
}
</style>
