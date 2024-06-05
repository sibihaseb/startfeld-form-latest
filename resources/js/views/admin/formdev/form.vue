<template>
  <div class="main-view">
    <div class="layout_margin">
      <div class="mb-4">
        <el-button type="primary" @click="toggleFormSection"
          >Add Questions</el-button
        >
        <div>
          <p>Steps: {{ steps }}</p>
          <pre>{{ allQuestions }}</pre>
        </div>
        <div v-if="isVisible">
          <div class="section">
            <add-field
              :step="steps"
              @cancel="toggleFormSection"
              @submit="onSubmit"
            ></add-field>
          </div>
        </div>

        <wizard-view :questions="steps"></wizard-view>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, Ref, toRaw } from "vue";
import AddField from "@/components/addField.vue";
import WizardView from "@/components/wizardView.vue";
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
