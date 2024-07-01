<template>
  <div class="main-view">
    <div v-if="props.allQuestions.length > 0" class="form__wizard">
      <div class="wizard-header">
        <el-steps class="steps" finish-status="success">
          <el-step
            class="wizard-step"
            v-for="(value, index) in WizardProgressTracker.totalStep"
            :key="index"
            :active="index + 1"
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
            <div class="edit_option">
              <div>
                <p v-if="question.description">
                  {{
                    i18nLocale.locale.value === "de"
                      ? question.description.name.de
                      : question.description.name.en
                  }}
                </p>
              </div>
              <div>
                <i class="ri-pencil-fill edit-color" @click="editQuestion(question)"></i>
                <i
                  class="ri-delete-bin-line delete-color"
                  @click="deleteQuestion(question)"
                ></i>
              </div>
            </div>
          </div>
          <div v-else-if="question.answer_type === QuestionAnswerType.key">
            <applicant
              :saveProfile="applicantProfileData"
              v-if="question.options?.key === 'applicant'"
              :ref="
                (el) => {
                  applicantRefSet(el);
                }
              "
            />
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
                <div class="edit_option">
                  <div>
                    <p v-if="question.description">
                      {{
                        i18nLocale.locale.value === "de"
                          ? question.description.name.de
                          : question.description.name.en
                      }}
                    </p>
                  </div>
                  <div>
                    <i
                      class="ri-pencil-fill edit-color"
                      @click="editQuestion(question)"
                    ></i>
                    <i
                      class="ri-delete-bin-line delete-color"
                      @click="deleteQuestion(question)"
                    ></i>
                  </div>
                </div>
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
                  <div class="edit_option">
                    <div>
                      <p v-if="question.description">
                        {{
                          i18nLocale.locale.value === "de"
                            ? question.description.name.de
                            : question.description.name.en
                        }}
                      </p>
                    </div>
                    <div>
                      <i
                        class="ri-pencil-fill edit-color"
                        @click="editQuestion(question)"
                      ></i>
                      <i
                        class="ri-delete-bin-line delete-color"
                        @click="deleteQuestion(question)"
                      ></i>
                    </div>
                  </div>
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
                  <div class="edit_option">
                    <div>
                      <p v-if="question.description">
                        {{
                          i18nLocale.locale.value === "de"
                            ? question.description.name.de
                            : question.description.name.en
                        }}
                      </p>
                    </div>
                    <div>
                      <i
                        class="ri-pencil-fill edit-color"
                        @click="editQuestion(question)"
                      ></i>
                      <i
                        class="ri-delete-bin-line delete-color"
                        @click="deleteQuestion(question)"
                      ></i>
                    </div>
                  </div>
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
                <div>
                  <div class="edit_option">
                    <div>
                      <p v-if="question.description">
                        {{
                          i18nLocale.locale.value === "de"
                            ? question.description.name.de
                            : question.description.name.en
                        }}
                      </p>
                    </div>
                    <div>
                      <i
                        class="ri-pencil-fill edit-color"
                        @click="editQuestion(question)"
                      ></i>
                      <i
                        class="ri-delete-bin-line delete-color"
                        @click="deleteQuestion(question)"
                      ></i>
                    </div>
                  </div>
                  <el-radio-group v-model="allAnswer[index].value" @change="verifymodel">
                    <el-radio
                      v-for="option in question.options?.values"
                      :key="option.value"
                      :label="option.value"
                      >{{
                        i18nLocale.locale.value === "de" ? option.name.de : option.name.en
                      }}</el-radio
                    >
                  </el-radio-group>
                </div>
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
                <div>
                  <div class="edit_option">
                    <div>
                      <p v-if="question.description">
                        {{
                          i18nLocale.locale.value === "de"
                            ? question.description.name.de
                            : question.description.name.en
                        }}
                      </p>
                    </div>
                    <div>
                      <i
                        class="ri-pencil-fill edit-color"
                        @click="editQuestion(question)"
                      ></i>
                      <i
                        class="ri-delete-bin-line delete-color"
                        @click="deleteQuestion(question)"
                      ></i>
                    </div>
                  </div>
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
                </div>
              </el-form-item>

              <file-upload
                v-if="
                  !question.is_hidden && question.answer_type === QuestionAnswerType.file
                "
                :question="question"
                :answerValue="allAnswer[index].value"
                :formbuild="true"
                @file-submitted="saveFileToAnswers"
                @edit-file-question="editQuestion"
                @delete-file-question="deleteQuestion"
              ></file-upload>
            </el-form>
          </div>
        </div>
        <div class="next-step">
          <el-button
            size="large"
            v-show="
              WizardProgressTracker.activeStepNo + 1 < WizardProgressTracker.totalStep
            "
            type="primary"
            @click="wizardFormSubmit('forward')"
            >{{ $t("wizard.layout.labelButtonNext") }}</el-button
          >
          <el-button
            v-show="
              WizardProgressTracker.activeStepNo >= 1 &&
              WizardProgressTracker.totalStep > 1
            "
            size="large"
            type="primary"
            @click="wizardFormSubmit('back')"
            >{{ $t("wizard.layout.labelButtonBack") }}</el-button
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts" name="formBuild">
import { computed, onMounted, reactive, ref, watch } from "vue";
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
import type { ApplicantProfile, ApplicationStatus } from "../client";
import { ApplicantCurrentStatus } from "../client/models/ApplicantCurrentStatus";
import { ApplicantGender } from "../client/models/ApplicantGender";
import fileUpload from "@/components/fileUpload.vue";
import applicant from "@/components/applicant.vue";
import { wizardHelper } from "../client/helper/wizardHelper";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const i18nLocale = useI18n();
const allAnswer: Ref<QuestionAnswer[]> = ref([]);
const allQuestions: Ref<QuestionCreate[]> = ref([]);
const applicantRef = ref();
const applicantProfileData: Ref<ApplicantProfile> = ref({
  id: 0,
  surname: "",
  firstname: "",
  address: "",
  zip: "",
  city: "",
  email: "",
  phone: "",
  about_us: ApplicantCurrentStatus.social_media,
  gender: ApplicantGender.male,
});
const emit = defineEmits(["edit", "delete"]);
const props = defineProps<{
  allQuestions: QuestionCreate[];
  steps: StepCreate;
}>();

const applicantRefSet = (el) => {
  applicantRef.value = el;
};

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
  stepAnswerMap();
  console.log(allAnswer.value);
  WizardProgressTracker.activeStepNo = props.steps.activeStepNo;
  WizardProgressTracker.totalStep = props.steps.totalStep.length;
  stepDisplay(props.steps.activeStepNo);
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

const wizardFormSubmit = async (direction: string) => {
  stepAnswerMap();

  if (direction === "forward") {
    nextQuestion();
  }
  if (direction === "back") {
    lastQuestion();
  }
};

const nextQuestion = () => {
  if (WizardProgressTracker.activeStepNo++ > WizardProgressTracker.totalStep - 2) {
    WizardProgressTracker.activeStepNo = 0;
  }

  stepDisplay(WizardProgressTracker.activeStepNo + 1);
};

const lastQuestion = () => {
  if (WizardProgressTracker.activeStepNo-- > WizardProgressTracker.totalStep) {
    WizardProgressTracker.activeStepNo = 0;
  }
  stepDisplay(WizardProgressTracker.activeStepNo + 1);
};

const jumpToStep = async (stepNo: number) => {
  WizardProgressTracker.activeStepNo = stepNo;
  stepAnswerMap();
  stepDisplay(WizardProgressTracker.activeStepNo + 1);
};

const stepAnswerMap = () => {
  wizardHelper.loadWizardBuild(allQuestions, allAnswer);
};

const editQuestion = (editQuestion: QuestionCreate) => {
  emit("edit", { editQuestion });
};

const deleteQuestion = (deleteQuestion: QuestionCreate) => {
  // Find the index of the createdQuestion in the array
  emit("delete", { ...deleteQuestion });
};
</script>
<style lang="scss" scoped>
@import "../assets/scss/wizard";
@import "../assets/scss/colors";

.edit_option {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.edit-color {
  margin-right: 10px;
  cursor: pointer;
  color: $primary;
}

.delete-color {
  cursor: pointer;
  color: $error;
}
</style>
