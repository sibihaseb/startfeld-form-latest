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
            :active="index"
          />
        </el-steps>
      </div>
      <div class="wizard">
        <div class="questions" v-for="question in singleStep" :key="question.id">
          <div v-if="question.answer_type === QuestionAnswerType.title">
            <h3>
              {{
                i18nLocale.locale.value === "de"
                  ? question.title.name.de
                  : question.title.name.en
              }}
            </h3>
            <p>
              {{
                i18nLocale.locale.value === "de"
                  ? question.description?.name.de
                  : question.description?.name.en
              }}
            </p>
          </div>
          <div v-else>
            <el-form
              require-asterisk-position="right"
              label-position="top"
              :model="allAnswer"
              ref="wizardFormRef"
              class="wizard-form"
              @submit.prevent="false"
            >
              <el-form-item
                v-if="
                  (!question.is_hidden &&
                    question.answer_type === QuestionAnswerType.text) ||
                  question.answer_type === QuestionAnswerType.number ||
                  question.answer_type === QuestionAnswerType.textarea
                "
                :label="
                  i18nLocale.locale.value === 'de'
                    ? question.title.name.de
                    : question.title.name.en
                "
              >
                <p v-if="question.description">
                  {{
                    i18nLocale.locale.value === "de"
                      ? question.description.name.de
                      : question.description.name.en
                  }}
                </p>
                <el-input
                  :placeholder="
                    i18nLocale.locale.value === 'de'
                      ? question.title.name.de
                      : question.title.name.en
                  "
                  :type="question.answer_type"
                  v-model="allAnswer[question.id].value"
                />
                <div
                  class="el-form-item__error"
                  v-for="error in wizardValidator$.$errors"
                  :key="error.$uid"
                >
                  <span v-if="error.$uid === question.id + '.value-required'">{{
                    error.$message
                  }}</span>
                  <span v-if="error.$uid === question.id + '.value-maxLength'">{{
                    error.$message
                  }}</span>
                </div>
              </el-form-item>

              <el-form-item
                v-if="
                  !question.is_hidden &&
                  question.answer_type === QuestionAnswerType.date &&
                  allAnswer[7].value !== 'Company is not yet Founded'
                "
                :label="
                  i18nLocale.locale.value === 'de'
                    ? question.title.name.de
                    : question.title.name.en
                "
              >
                <p v-if="question.description">
                  {{
                    i18nLocale.locale.value === "de"
                      ? question.description.name.de
                      : question.description.name.en
                  }}
                </p>
                <el-date-picker
                  :disabled="wizardState.disable"
                  :placeholder="
                    i18nLocale.locale.value === 'de'
                      ? question.title.name.de
                      : question.title.name.en
                  "
                  v-model="allAnswer[question.id].value"
                />
                <div
                  class="el-form-item__error"
                  v-for="error in wizardValidator$.$errors"
                  :key="error.$uid"
                >
                  <span v-if="error.$uid === question.id + '.value-required'">{{
                    error.$message
                  }}</span>
                </div>
              </el-form-item>

              <el-form-item
                v-if="
                  !question.is_hidden &&
                  question.answer_type === QuestionAnswerType.checkbox
                "
                :label="
                  i18nLocale.locale.value === 'de'
                    ? question.title.name.de
                    : question.title.name.en
                "
              >
                <p v-if="question.description">
                  {{
                    i18nLocale.locale.value === "de"
                      ? question.description.name.de
                      : question.description.name.en
                  }}
                </p>
                <el-checkbox-group
                  v-model="allAnswer[question.id].value"
                  :disabled="wizardState.disable"
                >
                  <el-checkbox
                    class="custom-checkbox-btn"
                    v-for="option in question.options?.values"
                    :key="option.value"
                    :label="option.value"
                  >
                    {{
                      i18nLocale.locale.value === "de" ? option.name.de : option.name.en
                    }}</el-checkbox
                  >
                </el-checkbox-group>
                <div
                  class="el-form-item__error"
                  v-for="error in wizardValidator$.$errors"
                  :key="error.$uid"
                >
                  <span v-if="error.$uid === question.id + '.value-required'">{{
                    error.$message
                  }}</span>
                </div>
              </el-form-item>

              <el-form-item
                v-if="
                  !question.is_hidden && question.answer_type === QuestionAnswerType.radio
                "
                :label="
                  i18nLocale.locale.value === 'de'
                    ? question.title.name.de
                    : question.title.name.en
                "
              >
                <p v-if="question.description">
                  {{
                    i18nLocale.locale.value === "de"
                      ? question.description.name.de
                      : question.description.name.en
                  }}
                </p>
                <el-radio-group
                  v-model="allAnswer[question.id].value"
                  @change="verifymodel"
                  :disabled="wizardState.disable"
                >
                  <el-radio
                    v-for="option in question.options?.values"
                    :key="option.value"
                    :label="option.value"
                    >{{
                      i18nLocale.locale.value === "de" ? option.name.de : option.name.en
                    }}</el-radio
                  >
                </el-radio-group>
                <el-input
                  :disabled="wizardState.disable"
                  v-if="allAnswer[question.id].value === 'other'"
                  v-model="allAnswer[question.id].other"
                  type="textarea"
                />
                <div
                  class="el-form-item__error"
                  v-for="error in wizardValidator$.$errors"
                  :key="error.$uid"
                >
                  <span v-if="error.$uid === question.id + '.value-required'">{{
                    error.$message
                  }}</span>
                </div>
              </el-form-item>

              <el-form-item
                v-if="
                  !question.is_hidden &&
                  question.answer_type === QuestionAnswerType.dropdown
                "
                :label="
                  i18nLocale.locale.value === 'de'
                    ? question.title.name.de
                    : question.title.name.en
                "
              >
                <p v-if="question.description">
                  {{
                    i18nLocale.locale.value === "de"
                      ? question.description.name.de
                      : question.description.name.en
                  }}
                </p>
                <el-select
                  :disabled="wizardState.disable"
                  v-model="allAnswer[question.id].value"
                  :placeholder="
                    i18nLocale.locale.value === 'de'
                      ? question.title.name.de
                      : question.title.name.en
                  "
                >
                  <el-option
                    v-for="option in question.options?.values"
                    :key="option.value"
                    :label="
                      i18nLocale.locale.value === 'de' ? option.name.de : option.name.en
                    "
                    :value="option.value"
                  />
                </el-select>
                <div
                  class="el-form-item__error"
                  v-for="error in wizardValidator$.$errors"
                  :key="error.$uid"
                >
                  <span v-if="error.$uid === question.id + '.value-required'">{{
                    error.$message
                  }}</span>
                </div>
              </el-form-item>

              <file-upload
                v-if="
                  !question.is_hidden && question.answer_type === QuestionAnswerType.file
                "
                :question="question"
                :disable="wizardState.disable"
                :answerValue="allAnswer[question.id].value"
                @file-submitted="saveFileToAnswers"
              ></file-upload>
            </el-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts" name="formBuild">
import { computed, onMounted, reactive, ref } from "vue";
import type { Ref } from "vue";
import type {
  QuestionCreate,
  StepCreate,
  QuestionAnswer,
  StepDetailProcess,
  TeamMemberProfile,
  AdminPrivateNote,
} from "../client";
import { QuestionAnswerType } from "../client/models/QuestionAnswerType";
import fileUpload from "@/components/fileUpload.vue";
import { wizardHelper } from "../client/helper/wizardHelper";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const i18nLocale = useI18n();
const allQuestions: Ref<Question[]> = ref([]);
const props = defineProps<{
  allQuestions: QuestionCreate[];
  steps: StepCreate;
}>();

const WizardProgressTracker: StepDetailProcess = reactive({
  activeStepNo: 0,
  totalStep: 0,
  errorStep: [],
});

const singleStep: Ref<QuestionCreate[]> = ref([]);

const stepDisplay = (stepNumber: number) => {
  singleStep.value = [];
  singleStep.value = allQuestions.value.filter(
    (question) => question.step === stepNumber
  );
  console.log(singleStep.value);
};

onMounted(() => {
  allQuestions.value = props.allQuestions;
  console.log(allQuestions.value);
  stepDisplay(props.steps.activeStepNo);
});
</script>
<style lang="scss">
@import "../assets/scss/wizard.scss";
</style>
