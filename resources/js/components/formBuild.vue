<template>
  <div class="main-view">
    <div v-if="props.allQuestions.length > 0" class="form__wizard">
      <div class="wizard-header">
        <el-steps class="steps" finish-status="success">
          <el-step
            class="wizard-step"
            v-for="(value, index) in props.steps.totalStep"
            :key="index"
            :active="index"
            @click="jumpToStep(index)"
          />
        </el-steps>
      </div>
      <div class="wizard">
        <div class="questions" v-for="(question, index) in singleStep" :key="question.id">
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
                  v-model="allAnswer[index].value"
                />
              </el-form-item>

              <el-form-item
                v-if="
                  !question.is_hidden && question.answer_type === QuestionAnswerType.date
                "
                :label="
                  i18nLocale.locale.value === 'de'
                    ? question.title.name.de
                    : question.title.name.en
                "
              >
                <div>
                  <p v-if="question.description">
                    {{
                      i18nLocale.locale.value === "de"
                        ? question.description.name.de
                        : question.description.name.en
                    }}
                  </p>
                  <el-date-picker
                    :placeholder="
                      i18nLocale.locale.value === 'de'
                        ? question.title.name.de
                        : question.title.name.en
                    "
                    v-model="allAnswer[index].value"
                  />
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
                <div>
                  <p v-if="question.description">
                    {{
                      i18nLocale.locale.value === "de"
                        ? question.description.name.de
                        : question.description.name.en
                    }}
                  </p>
                  <el-checkbox-group v-model="allAnswer[index].value">
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
                <el-input
                  v-if="allAnswer[index].value === 'other'"
                  v-model="allAnswer[index].other"
                  type="textarea"
                />
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
                  v-model="allAnswer[index].value"
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
              </el-form-item>

              <file-upload
                v-if="
                  !question.is_hidden && question.answer_type === QuestionAnswerType.file
                "
                :question="question"
                :answerValue="allAnswer[index].value"
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
const allAnswer: Ref<QuestionAnswer[]> = ref([]);
const allQuestions: Ref<QuestionCreate[]> = ref([]);
const singleStepAnswers: Ref<QuestionAnswer[]> = ref([]);
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
};

onMounted(() => {
  allQuestions.value = props.allQuestions;
  WizardProgressTracker.activeStepNo = props.steps.activeStepNo;
  WizardProgressTracker.totalStep = props.steps.totalStep.length;
  stepDisplay(props.steps.activeStepNo);
  stepAnswerMap();
});

const verifymodel = (value) => {
  let Qid: number;
  singleStep.value.forEach((question, index) => {
    if (question.answer_type === QuestionAnswerType.radio) {
      question.options?.values?.forEach((option) => {
        if (value === option.value) {
          Qid = index;
          if (value !== "other") {
            delete allAnswer.value[index].other;
          }
        }
      });
    }
  });
};

const saveFileToAnswers = (question: QuestionAnswer) => {
  allAnswer.value[question.question_id].value = question.value;
};

const jumpToStep = async (stepNo: number) => {
  WizardProgressTracker.activeStepNo = stepNo;
  stepAnswerMap();
  stepDisplay(WizardProgressTracker.activeStepNo + 1);
};

const stepAnswerMap = () => {
  wizardHelper.loadWizardBuild(allQuestions, allAnswer);
};
</script>
<style lang="scss">
@import "../assets/scss/wizard";
</style>
