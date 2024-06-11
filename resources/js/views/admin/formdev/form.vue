<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button type="primary" @click="toggleFormSection">Add Questions</el-button>
        <div v-if="isVisible">
          <div class="section">
            <add-field
              :step="steps"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></add-field>
          </div>
        </div>

        <div v-if="!isVisible">
          <form-build :allQuestions="allQuestions"></form-build>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, Ref, toRaw } from "vue";
import AddField from "@/components/addField.vue";
import formBuild from "@/components/formBuild.vue";
import type { QuestionCreate } from "../../../client/index";

const allQuestions: Ref<QuestionCreate[]> = ref([]);

const isVisible = ref(false);
const steps = ref<number>(0);

const toggleFormSection = () => {
  isVisible.value = !isVisible.value;
};
const onSubmit = (form: QuestionCreate) => {
  steps.value++;
  allQuestions.value.push(form);
  toggleFormSection();
};
</script>
