<template>
  <div class="main-view">
    <div v-if="allQuestions.length > 0" class="form__wizard">
      <div class="wizard-header">
        <el-steps
          :active="WizardProgressTracker.activeStepNo"
          class="steps"
          finish-status="success"
          v-if="
            (WizardProgressTracker.errorStep && wizardState.flag === '') ||
            wizardState.flag === 'started' ||
            wizardState.flag === 'edit' ||
            wizardState.flag === 'view'
          "
        >
          <el-step
            class="wizard-step"
            v-for="(step, index) in WizardProgressTracker.errorStep"
            :key="index"
            :status="step.status"
            :title="step.status"
            :active="index"
            :class="step.status === 'error' ? step.status : ''"
            @click="jumpToStep(index)"
          />
        </el-steps>
      </div>
      <div
        class="wizard"
        v-if="
          wizardState.flag === '' ||
          wizardState.flag === 'started' ||
          wizardState.flag === 'edit' ||
          wizardState.flag === 'view'
        "
      >
        <div
          class="mail-msg box"
          v-if="wizardState.successMsg && applicantStore.applicantToken"
        >
          <span class="space-bottom">{{ wizardState.successMsg }}</span>
          <span
            >{{ $t("wizard.mainContactDetail.titleToken") + " : " }}
            <a class="link" :href="SITEURL + '/form/' + applicantStore.applicantToken">{{
              SITEURL + "/" + applicantStore.applicantToken
            }}</a>
          </span>
        </div>
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
          <div v-else-if="question.answer_type === QuestionAnswerType.key">
            <applicant
              :disable="wizardState.disable"
              :saveProfile="applicantProfileData"
              :error="wizardState.applicantErrorMsg"
              v-if="question.options?.key === 'applicant'"
              :ref="
                (el) => {
                  applicantRefSet(el);
                }
              "
            />
            <div v-if="question.options?.key === 'team_members'">
              <team-member-component
                v-for="(member, index) in teamMemberData"
                :teamMemberProfileData="member"
                :memberIndex="index"
                :disable="wizardState.disable"
                :key="index"
              />
              <div class="action-bt-member">
                <el-button
                  v-if="!wizardState.disable"
                  type="primary"
                  @click="teamMemberAdd"
                >
                  {{ $t("wizard.mainContactDetail.titleButtonAddMemeber") }}
                </el-button>
                <el-button
                  v-show="teamMemberData.length > 1 && !wizardState.disable"
                  class="remove-member"
                  @click="teamMemberRemove"
                >
                  {{ $t("wizard.mainContactDetail.titleButtonRemoveMember") }}
                </el-button>
              </div>
            </div>
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
                  :disabled="wizardState.disable"
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

        <div
          class="private-note"
          v-if="route.name === 'application_view' || route.name === 'application_edit'"
        >
          <el-form label-position="top">
            <el-form-item
              label="Private Note"
              v-if="adminNotes[WizardProgressTracker.activeStepNo]"
            >
              <label class="private-note-text">{{
                $t("wizard.layout.privateNotelableText")
              }}</label>
              <el-input
                type="textarea"
                v-model="adminNotes[WizardProgressTracker.activeStepNo].value"
              />
            </el-form-item>
          </el-form>
        </div>
        <div class="next-step">
          <el-button
            size="large"
            v-show="
              WizardProgressTracker.activeStepNo + 1 < WizardProgressTracker.totalStep
            "
            type="primary"
            :disabled="wizardState.loading"
            :loading="wizardState.loading"
            @click="wizardFormSubmit('forward')"
            >{{ $t("wizard.layout.labelButtonNext") }}</el-button
          >
          <div
            class="submit-save-action"
            v-show="
              WizardProgressTracker.activeStepNo + 1 ===
                WizardProgressTracker.totalStep && route.name === 'wizard'
            "
          >
            <el-button
              size="large"
              class="space-left-action-bt"
              type="primary"
              :disabled="wizardState.loading"
              :loading="wizardState.loading"
              @click="wizardFormSubmit('save')"
              >{{ $t("wizard.layout.labelButtonSave") }}</el-button
            >
            <el-button
              size="large"
              type="primary"
              :disabled="wizardState.loading"
              :loading="wizardState.loading"
              @click="wizardFormSubmit('submitted')"
              >{{ $t("wizard.layout.labelButtonSubmit") }}</el-button
            >
          </div>
          <div
            v-show="
              WizardProgressTracker.activeStepNo + 1 ===
                WizardProgressTracker.totalStep && route.name !== 'wizard'
            "
          >
            <el-button
              size="large"
              class="accept-bt"
              type="primary"
              :disabled="wizardState.loading"
              :loading="wizardState.loading"
              @click="applicationUpdate(ApplicationStatusType.accepted)"
              >{{ $t("wizard.layout.labelButtonAccept") }}</el-button
            >
            <el-button
              size="large"
              class="reject-bt"
              type="primary"
              :disabled="wizardState.loading"
              :loading="wizardState.loading"
              @click="applicationUpdate(ApplicationStatusType.rejected)"
              >{{ $t("wizard.layout.labelButtonReject") }}</el-button
            >
          </div>
          <el-button
            v-show="WizardProgressTracker.activeStepNo > 0"
            size="large"
            type="primary"
            @click="wizardFormSubmit('back')"
            >{{ $t("wizard.layout.labelButtonBack") }}</el-button
          >
        </div>
      </div>
      <div v-else>
        <div class="form-submitted">
          <i class="ri-checkbox-circle-line ri-10x success"></i>
          <h3>{{ $t("wizard.layout.formSubmittedSuccessMessage") }}</h3>
        </div>
      </div>
    </div>
    <div v-else class="form-submitted">
      <h2>{{ $t("wizard.layout.noQuestionWizard") }}</h2>
    </div>
  </div>
</template>

<script setup lang="ts" name="wizard">
import { computed, onMounted, reactive, ref } from "vue";
import type { Ref } from "vue";
import { applicationService, ApplicationStatusType } from "../client";
import type { ApplicantProfile, ApplicationStatus } from "../client";
import type {
  Question,
  QuestionAnswer,
  StepDetailProcess,
  TeamMemberProfile,
  AdminPrivateNote,
} from "../client";
import { QuestionAnswerType } from "../client/models/QuestionAnswerType";
import { ApplicantCurrentStatus } from "../client/models/ApplicantCurrentStatus";
import { ApplicantGender } from "../client/models/ApplicantGender";
import { wizardService } from "../client/services/wizardService";
import { wizardHelper } from "../client/helper/wizardHelper";
import applicant from "@/components/applicant.vue";
import teamMemberComponent from "@/components/teamMember.vue";
import fileUpload from "@/components/fileUpload.vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import { UploadInstance } from "element-plus";
import { useApplicantStore } from "../store";
import { applicantService } from "../client/index";
import { required, maxLength } from "../plugins/i18n-validators";
import { useVuelidate } from "@vuelidate/core";
import { ElMessage } from "element-plus";
import router from "../router";

const { t } = useI18n();
const i18nLocale = useI18n();
const route = useRoute();
const applicantRef = ref();
const uploadRef = ref<UploadInstance>();
const SITEURL = import.meta.env.VITE_APP_URL;
const applicantStore = useApplicantStore();

const wizardState = reactive({
  successMsg: "",
  errorMsg: "",
  applicantErrorMsg: "",
  loading: false,
  validatedProfile: false,
  flag: "",
  applicantCreated: false,
  validatedMembers: false,
  disable: false,
  formError: false,
});

const WizardProgressTracker: StepDetailProcess = reactive({
  activeStepNo: 0,
  totalStep: 0,
  errorStep: [],
});
const allQuestions: Ref<Question[]> = ref([]);
const singleStep: Ref<Question[]> = ref([]);
const answerWithFiles: Ref<QuestionAnswer[]> = ref([]);
const allAnswer: Ref<QuestionAnswer[]> = ref([]);
const adminNotes: Ref<AdminPrivateNote[]> = ref([]);
const singleStepAnswers: Ref<QuestionAnswer[]> = ref([]);
const CurrentApplicationStatus: Ref<ApplicationStatus | undefined> = ref();
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

const teamMemberData: Ref<TeamMemberProfile[]> = ref([
  {
    surname: "",
    firstname: "",
    address: "",
    zip: "",
    city: "",
    email: "",
    phone: "",
    about_us: ApplicantCurrentStatus.social_media,
    gender: ApplicantGender.male,
  },
]);

const teamMemberAdd = () => {
  teamMemberData.value.push({
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
};

const props = defineProps({
  token: {
    type: String,
  },
  flag: {
    type: String,
  },
  disable: {
    type: Boolean,
  },
});

const teamMemberRemove = () => {
  let lastelement = teamMemberData.value.length;
  if (lastelement > 1) {
    teamMemberData.value.splice(lastelement - 1, 1);
  }
};

const wizardFormSubmit = async (direction: string) => {
  stepAnswerMap();
  wizardState.validatedProfile = false;
  let applicantValidation = singleStep.value.find(
    (value) => value.options?.key === "applicant"
  );
  if (applicantValidation && direction !== "back") {
    if (applicantStore.token) {
      updateApplicant();
    } else {
      await applicantCreate();
    }
  }

  if (!wizardState.errorMsg && wizardState.errorMsg === "" && direction === "forward") {
    nextQuestion();
  }
  if (!wizardState.errorMsg && wizardState.errorMsg === "" && direction === "back") {
    lastQuestion();
  }
  if (direction === "submitted") {
    await submitWizardForm();
  }

  if (applicantStore.token) {
    await submitQuestionAnswer();
  }

  if (direction === ApplicationStatusType.accepted) {
    applicationUpdate(ApplicationStatusType.accepted);
  }

  if (direction === ApplicationStatusType.rejected) {
    applicationUpdate(ApplicationStatusType.rejected);
  }
  wizardState.loading = false;
};

const nextQuestion = () => {
  if (!wizardState.validatedProfile) {
    if (WizardProgressTracker.activeStepNo++ > WizardProgressTracker.totalStep - 2) {
      WizardProgressTracker.activeStepNo = 0;
    }
    if (route.params.token !== undefined && route.params.token !== "") {
      stepDisplay(WizardProgressTracker.activeStepNo + 1);
    } else {
      stepDisplay(WizardProgressTracker.activeStepNo + 1);
    }
  }
};

const lastQuestion = () => {
  if (WizardProgressTracker.activeStepNo-- > WizardProgressTracker.totalStep) {
    WizardProgressTracker.activeStepNo = 0;
  }
  stepDisplay(WizardProgressTracker.activeStepNo + 1);
};

const saveFileToAnswers = (question: QuestionAnswer) => {
  allAnswer.value[question.question_id].value = question.value;
};

const submitWizardForm = async () => {
  await new Promise<boolean>(function (resolve, reject) {
    if (!wizardState.validatedProfile) {
      wizardState.formError = validateForm();
      if (!wizardState.formError) {
        wizardState.flag = "submitted";
        WizardProgressTracker.activeStepNo++;
      }
    }
    resolve(true);
  });
};

const jumpToStep = async (stepNo: number) => {
  if (applicantStore.applicantToken) {
    WizardProgressTracker.activeStepNo = stepNo;
    stepAnswerMap();
    await submitQuestionAnswer();
    stepDisplay(WizardProgressTracker.activeStepNo + 1);
  }
};

const stepDisplay = (stepNumber: number) => {
  singleStep.value = [];
  singleStep.value = allQuestions.value.filter(
    (question) => question.step === stepNumber
  );
};

const applicationUpdate = (flag: string) => {
  if (applicantProfileData.value.token) {
    let formData = new FormData();
    formData.append("flag", flag);
    applicationService
      .update(applicantProfileData.value.token, formData)
      .then((response) => {
        router.push({ name: "application" });
        ElMessage({
          type: "success",
          message: t("admin.application.list.statusChangeSuccessMessage"),
        });
      })
      .catch((error) => {
        ElMessage({
          type: "error",
          message: t("admin.application.list.statusChangeErrorMessage"),
        });
      });
  }
};

const stepAnswerMap = () => {
  wizardHelper.stepAnswerMap(singleStepAnswers, allAnswer, singleStep, teamMemberData);
};

const applicantCreate = async () => {
  wizardState.errorMsg = "";
  wizardState.validatedProfile = applicantRef.value.validateFunction();
  if (!wizardState.validatedProfile && !applicantStore.applicantToken) {
    wizardState.loading = true;
    let formData = new FormData();
    Object.entries(applicantProfileData.value).forEach(([key, value]) => {
      formData.append(key, value ? value.toString() : "");
    });
    try {
      const response: ApplicantProfile = await applicantService.createApplicant(
        formData,
        i18nLocale.locale.value
      );
      applicantProfileData.value = structuredClone(response);
      if (response.token) {
        applicantStore.setApplicant(response.token);
      }
      wizardState.loading = false;
      wizardState.successMsg = t(
        "wizard.mainContactDetail.successApplicantRegisteredMessage"
      );
      wizardState.applicantCreated = true;
    } catch (error: any) {
      wizardState.applicantErrorMsg = error.data.message;
      wizardState.errorMsg = error.data.message;
      wizardState.loading = false;
    }
  }
};

const getApplicant = () => {
  applicantService
    .loadApplicant(route.params.token as string, i18nLocale.locale.value)
    .then((response: ApplicantProfile) => {
      applicantProfileData.value = structuredClone(response);
      if (response.token) {
        applicantStore.setApplicant(response.token);
      }
    });
};

const updateApplicant = () => {
  wizardState.validatedProfile = applicantRef.value.validateFunction();
  if (
    !wizardState.validatedProfile &&
    applicantProfileData.value.token === applicantStore.token
  ) {
    wizardState.loading = true;
    let formData = new FormData();
    Object.entries(applicantProfileData.value).forEach(([key, value]) => {
      formData.append(key, value ? value.toString() : "");
    });
    applicantService
      .updateApplicant(
        formData,
        applicantProfileData.value.token,
        i18nLocale.locale.value
      )
      .then((response: ApplicantProfile) => {
        applicantProfileData.value = structuredClone(response);
        if (response.token) {
          applicantStore.setApplicant(response.token);
        }
        wizardState.loading = false;
      })
      .catch((error) => {
        wizardState.applicantErrorMsg = error.data.message;
        wizardState.loading = false;
      });
  }
};

const submitQuestionAnswer = async () => {
  if (applicantStore.token) {
    let formData = new FormData();
    var objectArray: QuestionAnswer[] = [];
    answerWithFiles.value = [];
    Object.entries(singleStepAnswers.value).forEach(([key, answer]) => {
      if (answer.value !== undefined) {
        if (answer.other) {
          let newAnswerValue = {
            value: answer.value,
            other: answer.other,
          };
          answer.value = JSON.stringify(newAnswerValue);
          objectArray.push(answer);
          answer.value = "other";
        } else {
          if (answer.value instanceof File) {
            answerWithFiles.value.push(answer);
          } else {
            objectArray.push(answer);
          }
        }
      }
    });
    if (wizardState.applicantCreated) {
      Object.entries(allAnswer.value).forEach(([key, answer]) => {
        if (answer.value !== undefined) {
          objectArray.push(answer);
        }
      });
      wizardState.applicantCreated = false;
    }
    formData.append("answers", JSON.stringify(objectArray));

    var objectArrayForNotes: AdminPrivateNote[] = [];
    Object.entries(adminNotes.value).forEach(([key, note]) => {
      if (note.value !== undefined && note.value !== "") {
        objectArrayForNotes.push(note);
      }
    });
    if (objectArrayForNotes.length > 0) {
      formData.append("adminNotes", JSON.stringify(objectArrayForNotes));
    }
    if (
      objectArray.length > 0 ||
      objectArrayForNotes.length > 0 ||
      wizardState.flag === ApplicationStatusType.submitted
    ) {
      await wizardService.saveAnswers(
        formData,
        applicantStore.token,
        wizardState.flag,
        i18nLocale.locale.value
      );
    }
    if (answerWithFiles.value.length > 0) {
      wizardState.loading = true;
      let fileData = new FormData();
      Object.entries(answerWithFiles.value).forEach(([key, answer]) => {
        if (answer.value instanceof File) {
          fileData.append(JSON.stringify(answer.question_id), answer.value);
        }
      });
      try {
        const response = await wizardService.saveAnswerFiles(
          fileData,
          applicantStore.token
        );
        response.forEach((fileAnswer) => {
          wizardState.loading = false;
          allAnswer.value[fileAnswer.question_id].value = fileAnswer.value;
        });
      } catch (error: any) {
        wizardState.loading = false;
        wizardState.errorMsg = error.message;
      }
    }
  }
};

const LOADWIZARD = (token) => {
  if (!token) {
    token = undefined;
    applicantStore.resetApplicant();
  }
  wizardService
    .loadWizard(token, i18nLocale.locale.value)
    .then((response: Question[]) => {
      allQuestions.value = response;
      let routeName: string | undefined = route.name?.toString();
      wizardHelper.loadWizard(
        allQuestions,
        allAnswer,
        WizardProgressTracker,
        wizardState.flag,
        applicantProfileData,
        adminNotes,
        teamMemberData,
        routeName
      );
      stepDisplay(WizardProgressTracker.activeStepNo + 1);
    })
    .catch((error) => {
      router.push({ name: "404" });
    });
};

onMounted(() => {
  wizardState.disable = props.disable;
  if (route.params.token !== undefined && route) {
    var token: string | string[] | undefined | null =
      route.params.token !== undefined ? route.params.token : applicantStore.token;
    if (token) {
      getApplicant();
      applicantService
        .loadApplicationStatus(route.params.token.toString())
        .then((value: ApplicationStatus) => {
          CurrentApplicationStatus.value = value;
          if (props.flag) {
            wizardState.flag = props.flag;
          } else {
            wizardState.flag = value.status;
          }
        });
    }
  }
  LOADWIZARD(token);
});

const verifymodel = (value) => {
  let Qid: number;
  singleStep.value.forEach((question) => {
    if (question.answer_type === QuestionAnswerType.radio) {
      question.options?.values?.forEach((option) => {
        if (value === option.value) {
          Qid = question.id;
          if (value !== "other") {
            delete allAnswer.value[question.id].other;
          }
        }
      });
    }
  });
};
const applicantRefSet = (el) => {
  applicantRef.value = el;
};

const getRules = computed(() => {
  let rules = {};
  allQuestions.value.forEach((question: Question, index: number) => {
    if (
      question.is_mandatory &&
      question.is_hidden !== true &&
      question.answer_type !== QuestionAnswerType.key
    ) {
      rules[question.id] = {
        value: {
          required,
        },
      };
    }
    if (question.answer_type === QuestionAnswerType.text) {
      rules[question.id] = {
        value: {
          maxLength,
        },
      };
    }
  });
  return rules;
});

// for adding team member scope
// const wizardValidator$ = useVuelidate(getRules, allAnswer.value, { $scope: memberScope });
const wizardValidator$ = useVuelidate(getRules, allAnswer.value);
const validateForm = () => {
  WizardProgressTracker.errorStep.forEach((error) => {
    error.status = "";
  });
  wizardState.validatedMembers = false;
  wizardValidator$.value.$touch();
  if (wizardValidator$.value.$error) {
    allQuestions.value.forEach((question, index) => {
      wizardValidator$.value.$errors.forEach((error) => {
        if (
          error.$uid === question.id + ".value-required" ||
          error.$uid === question.id + ".value-maxLength"
        ) {
          WizardProgressTracker.errorStep.forEach((stepProgress) => {
            if (stepProgress.stepNo === question.step) {
              stepProgress.status = "error";
            }
          });
        } else if (error.$property === "email") {
          wizardState.validatedMembers = false;
        }
      });
    });
    return true;
  } else {
    WizardProgressTracker.errorStep.forEach((error) => {
      error.status = "";
    });
    return false;
  }
};
</script>
<style lang="scss">
@import "../assets/scss/wizard.scss";
</style>
