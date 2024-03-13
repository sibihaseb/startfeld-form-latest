<template>
  <div class="main-view">
    <h1 class="title side-blue-dot-bar">
      {{ $t("admin.application.applicationManagement.title") }}
    </h1>
    <div>
      <el-input
        class="search"
        v-model="tableData.search"
        @keyup="searchValue"
        :placeholder="$t('admin.application.applicationManagement.placeholderSearch')"
      />
    </div>
    <table class="user-table">
      <thead>
        <tr>
          <th scope="col" class="fixed-width">
            {{ $t("admin.application.applicationManagement.labelName") }}
          </th>
          <th scope="col" class="fixed-width">
            {{ $t("admin.application.applicationManagement.labelEmail") }}
          </th>
          <th scope="col" class="fixed-width">
            {{ $t("admin.application.applicationManagement.labelProjectName") }}
          </th>
          <th scope="col" class="fixed-width">
            {{ $t("admin.application.applicationManagement.labelAppliedDate") }}
          </th>
          <th scope="col" class="role">
            {{ $t("admin.application.applicationManagement.labelApplicationStatus") }}
          </th>
          <th scope="col" class="action"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(applicant, index) in applicants" :key="index">
          <td
            :data-label="$t('admin.application.applicationManagement.labelName')"
            class="fixed-width"
          >
            {{ applicant.firstname }} {{ applicant.surname }}
          </td>
          <td
            :data-label="$t('admin.application.applicationManagement.labelEmail')"
            class="fixed-width"
          >
            {{ applicant.email }}
          </td>
          <td
            v-if="applicant.applicant_answer && applicant.applicant_answer !== undefined"
            :data-label="$t('admin.application.applicationManagement.labelEmail')"
            class="fixed-width"
          >
            {{ applicationProjectName(applicant.applicant_answer) }}
          </td>
          <td
            v-if="applicant.applicant_answer && applicant.applicant_answer !== undefined"
            :data-label="$t('admin.application.applicationManagement.labelAppliedDate')"
            class="fixed-width"
          >
            {{ updatedDate(applicant.applicant_status?.created_at) }}
          </td>
          <td
            :data-label="
              $t('admin.application.applicationManagement.labelApplicationStatus')
            "
            class="fixed-width"
            v-if="applicant.applicant_status"
          >
            <el-select
              size="small"
              v-model="applicant.applicant_status.status"
              class="applicant-status"
              @change="applicationUpdate(applicant.id)"
            >
              <el-option
                :label="
                  $t(
                    'admin.application.applicationManagement.labelSelectApplicationStatus'
                  )
                "
                disabled
                :value="
                  $t(
                    'admin.application.applicationManagement.labelSelectApplicationStatus'
                  )
                "
                >{{
                  $t(
                    "admin.application.applicationManagement.labelSelectApplicationStatus"
                  )
                }}</el-option
              >
              <el-option
                v-for="(status, index) in ApplicationStatusType"
                :label="index"
                :key="index"
                :value="status"
                >{{ status }}</el-option
              >
            </el-select>
          </td>
          <td class="action">
            <div class="action-alignment">
              <i
                class="ri-eye-line space-left click-icon"
                @click="viewApplication(applicant.token)"
                :title="$t('admin.application.applicationManagement.viewTitle')"
              >
              </i>
              <i
                class="ri-pencil-fill space click-icon"
                @click="editApplication(applicant.token)"
                :title="$t('admin.application.applicationManagement.editTitle')"
              ></i>
              <i
                v-if="applicant.token"
                class="ri-delete-bin-line space click-icon"
                @click="deleteApplication(applicant.token)"
                :title="$t('admin.application.applicationManagement.deleteTitle')"
              ></i>
              <i
                v-if="applicant.token"
                class="ri-file-pdf-line click-icon"
                :title="$t('admin.application.applicationManagement.pdfTitle')"
                @click="
                  pdfDownload(
                    applicant.token,
                    applicant.firstname + ' ' + applicant.surname
                  )
                "
              ></i>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <el-pagination
      v-if="tableData.total > 20"
      class="right-pagination"
      layout="prev, pager, next"
      :page-sizes="[20, 50]"
      :default-page-size="20"
      :page-count="tableData.pageCount"
      @current-change="setPage"
    >
    </el-pagination>
  </div>
</template>

<script setup lang="ts">
import { onMounted, reactive, ref } from "vue";
import type { Ref } from 'vue'
import { ApplicantTable, applicationService, type ApplicantProfile, ApplicationStatusType, ApplicationStatus, QuestionAnswer } from "../../../client";
import { useI18n } from "vue-i18n";
import router from "../../../router";
import moment from "moment";
import { ElMessage, ElMessageBox } from "element-plus";

const { t } = useI18n();
const i18nLocale = useI18n();
const SITEURL = import.meta.env.VITE_APP_URL;
const applicants: Ref<ApplicantProfile[]> = ref([]);
const tableData = reactive({
  search: "",
  page: 1,
  pageSize: 20,
  total: 0,
  pageCount: 0,
});

const loadApplicants = () => {
    applicationService.loadApplicants(tableData.page, tableData.pageSize,
    tableData.search,i18nLocale.locale.value).then((allApplicants: ApplicantTable) => {
    applicants.value = allApplicants.data;
    if (allApplicants.meta) {
        tableData.pageCount = allApplicants.meta?.last_page;
        tableData.total = allApplicants.meta?.total;
      }
    });
}

const applicationProjectName = (applicantAnswer: QuestionAnswer[]) => {

    if(applicantAnswer.length > 0 && applicantAnswer[0].value !== undefined)
    {
        return applicantAnswer[0].value;
    }
    return "";
}


const pdfDownload = (token: string, FullName: string) => {
    applicationService.downloadFormPdf(token).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response]));
    const link = document.createElement('a');
    link.href = url;
    let Date = moment().format("DD.MM.YYYY_HH:mm");
    link.setAttribute('download', FullName +'_'+ Date + '.pdf'); //or any other extension
    document.body.appendChild(link);
    link.click();
    });
}

onMounted(()=> {
    loadApplicants()
});

const searchValue = () => {
  setTimeout(() => {
    loadApplicants();
  }, 1000);
};

const applicationUpdate = (applicantId: number) => {
    let flag: string = "";
    let token: string = "";
    applicants.value.forEach((applicant: ApplicantProfile) =>{
        if(applicant.id === applicantId && applicant.applicant_status && applicant.token)
        {
            flag = applicant.applicant_status?.status;
            token = applicant.token;
        }
    })
    if(flag)
    {
        let formData = new FormData();
        formData.append('flag', flag);
        applicationService.update(token, formData).then((response: ApplicationStatus) => {
            ElMessage({
          type: "success",
          message: t("admin.application.list.statusChangeSuccessMessage"),
        });
        }).catch((error) => {
            ElMessage({
          type: "error",
          message: t("admin.application.list.statusChangeErrorMessage"),
        });
        });
    }
}

const viewApplication = (token?: string) => {
  router.push({ name: "application_view", params: { token: token } });
};

const editApplication = (token?: string) => {
  router.push({ name: "application_edit", params: { token: token } });
};

const updatedDate = (date: any) => {
  return moment(date).format("DD.MM.YYYY HH:mm");
};

const deleteApplication = (token: string) => {

        ElMessageBox.confirm(
        t("admin.application.list.deleteApplicationWarning.message"),
        t("admin.application.list.deleteApplicationWarning.title"),
        {
        confirmButtonText: t("admin.application.list.deleteConfirmButtonText"),
        cancelButtonText: t("admin.application.list.deleteCancelButtonText"),
        type: "warning",
        }
        ).then(() => {
            applicationService
            .delete(token)
            .then(() => {
                loadApplicants();
                ElMessage({
                type: "success",
                message: t("admin.application.list.applicationDeleteSuccessMsg"),
                });
            })
            .catch((error) => {
                ElMessage({
                type: "error",
                message: t("admin.application.list.applicationDeleteErrorMsg"),
                });
            });
        });
};

const setPage = (val: number) => {
  tableData.page = val;
  loadApplicants();
};
</script>

<style lang="scss">
@use "../../../assets/scss/colors.scss" as *;
.success_verify {
  margin-left: 10px;
  color: $success;
}
</style>
<style lang="scss" scoped>
@use "../../../assets/scss/colors.scss" as *;
.space {
  margin-right: 15px;
}
.space-left {
  margin-left: 15px;
  margin-right: 15px;
}
.right-pagination {
  justify-content: flex-end;
}

.search {
  max-width: 250px;
  margin-bottom: 20px;
}

.action-alignment {
  display: flex;
  align-items: end;
  justify-content: end;
}
</style>
