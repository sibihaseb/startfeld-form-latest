import { Ref } from "vue";
import type { QuestionAnswer, Question, TeamMemberProfile, WizardProgressTracker, ApplicantProfile,
AdminPrivateNote } from "../index";
import { wizardService } from '../index'
import { QuestionAnswerType } from '../index'
import { useAuthStore } from "../../store/storeAuth";
const authStore = useAuthStore();

export class wizardHelper{
    static stepAnswerMap(singleStepAnswers: Ref<QuestionAnswer[]>, allAnswer: Ref<QuestionAnswer[]>,
        singleStep: Ref<Question[]>, teamMemberData: Ref<TeamMemberProfile[]>) {
        singleStepAnswers.value = [];
      allAnswer.value.forEach((questionAnswer: QuestionAnswer, index: number) => {
        singleStep.value.forEach((question: Question, index: number) => {
          if (questionAnswer.question_id === question.id) {
            if (question.options?.key === "team_members") {
              teamMemberData.value.forEach((member, index, teamMember) => {
                if (
                  member.firstname === "" &&
                  member.surname === "" &&
                  teamMemberData.value.length > 1
                ) {
                  teamMember.splice(index, 1);
                }
              });
              if (
                teamMemberData.value.length > 0 &&
                teamMemberData.value[0].firstname &&
                teamMemberData.value[0].surname
              ) {
                let convertedMembers = JSON.stringify(teamMemberData.value);
                singleStepAnswers.value.push({
                  question_id: questionAnswer.question_id,
                  value: convertedMembers,
                });
              } else if (
                teamMemberData.value[0].firstname === "" &&
                teamMemberData.value[0].surname === ""
              ) {
                singleStepAnswers.value.push({
                  question_id: questionAnswer.question_id,
                  value: "",
                });
              }
            } else {
              singleStepAnswers.value.push(questionAnswer);
            }
          }
        });
      });
    }

    static loadWizard(allQuestions: Ref<Question[]>, allAnswer: Ref<QuestionAnswer[]>, WizardProgressTracker: WizardProgressTracker,
        flag: string, applicantProfileData: Ref<ApplicantProfile>, adminNotes: Ref<AdminPrivateNote[]>,
        teamMemberData: Ref<TeamMemberProfile[]>, routeName?: string)
        {
        allQuestions.value.forEach((question: Question, index: number) => {
            if (question.step > WizardProgressTracker.totalStep) {
              WizardProgressTracker.totalStep++;
              WizardProgressTracker.errorStep.push({
                stepNo: WizardProgressTracker.totalStep,
                status: "",
              });
              if (authStore.me && flag) {
                adminNotes.value.push({
                  user_id: authStore.me?.id,
                  applicant_id: applicantProfileData.value.id,
                  step_id: WizardProgressTracker.totalStep,
                  value: "",
                });
              }
            }
            if (
              question.answer_type !== QuestionAnswerType.title &&
              question.answer_type !== QuestionAnswerType.key
            ) {
              if (question.answer?.value && question.answer?.value !== undefined) {
                if (question.answer_type === QuestionAnswerType.radio) {
                  var valueVerified = this.isJson(question.answer.value);
                  if (valueVerified) {
                    let answerJson = JSON.parse(question.answer?.value.toString());

                    allAnswer.value[question.id as keyof object] = {
                      question_id: question.id,
                      value: answerJson.value,
                      other: answerJson.other,
                    };
                  } else {
                    allAnswer.value[question.id as keyof object] = {
                      question_id: question.id,
                      value: question.answer.value,
                    };
                  }
                } else {
                  allAnswer.value[question.id as keyof object] = {
                    question_id: question.id,
                    value: question.answer.value,
                  };
                }
              } else {
                allAnswer.value[question.id as keyof object] = { question_id: question.id };
              }
            } else if (
              question.answer_type === QuestionAnswerType.key &&
              question.options?.key === "team_members"
            ) {
              if (question.answer?.value) {
                allAnswer.value[question.id as keyof object] = {
                  question_id: question.id,
                  value: question.answer.value,
                };
                teamMemberData.value = JSON.parse(
                  JSON.parse(JSON.stringify(question.answer.value))
                );
              } else {
                allAnswer.value[question.id as keyof object] = { question_id: question.id };
              }
            }
          });
          if (
            authStore.me?.role === "admin" ||
            (authStore.me?.role === "superadmin" && routeName !== "wizard")
          ) {
            if(applicantProfileData.value.token)
            wizardService.loadAdminNotes(applicantProfileData.value.token).then((response: AdminPrivateNote[]) => {
              adminNotes.value.forEach((note) => {
                response.forEach((savedNote) => {
                  if (savedNote.step_id === note.step_id) {
                    note.value = savedNote.value;
                  }
                });
              });
            });
          }
    }

    static isJson(str) {
        try {
          JSON.parse(str);
        } catch (e) {
          return false;
        }
        return true;
      }
}

