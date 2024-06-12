<template>
  <div class="main-view">
    <div v-if="props.allQuestions.length > 0" class="form__wizard">
      <div class="wizard-header">
        <p>{{ props.steps.totalStep }}</p>
        <el-steps class="steps" finish-status="success">
          <el-step
            class="wizard-step"
            v-for="(value, index) in props.steps.totalStep"
            :key="index"
          />
        </el-steps>
      </div>
      <div class="wizard"></div>
    </div>
  </div>
</template>
<script setup lang="ts" name="formBuild">
import { QuestionCreate, StepCreate } from "../client";

const props = defineProps<{
  allQuestions: QuestionCreate[];
  steps: StepCreate;
}>();
</script>
<style lang="scss">
@import "../assets/scss/wizard.scss";
</style>
