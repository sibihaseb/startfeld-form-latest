<template>
  <div class="main-view">
    <div v-if="props.allQuestions.length > 0" class="form__wizard">
      <div class="wizard-header">
        <el-steps class="steps" finish-status="success">
          <el-step
            class="wizard-step"
            v-for="(question, index) in props.allQuestions"
            :key="index"
          />
        </el-steps>
      </div>
      <div class="wizard"></div>
    </div>
  </div>
</template>
<script setup lang="ts" name="formBuild">
import { QuestionCreate } from "../client";

const props = defineProps<{
  allQuestions: QuestionCreate[];
}>();
</script>
<style lang="scss">
@import "../assets/scss/wizard.scss";
</style>
