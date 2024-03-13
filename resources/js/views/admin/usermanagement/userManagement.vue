<template>
  <div class="main-view">
    <h1 class="title side-blue-dot-bar">{{ $t("admin.users.userManagement.title") }}</h1>
    <div class="table-head">
      <el-input
        class="search"
        v-model="tableData.search"
        @keyup="searchValue"
        :placeholder="$t('admin.users.userManagement.placeholderSearch')"
      />
      <el-button @click="createUser">
        <i class="ri-add-line spcae-left"></i>{{
        $t("admin.users.userManagement.createUserButton")
      }}</el-button>
    </div>
    <table class="user-table">
      <thead>
        <tr>
          <th scope="col" class="fixed-width">
            {{ $t("admin.users.userManagement.labelName") }}
          </th>
          <th scope="col" class="fixed-width">
            {{ $t("admin.users.userManagement.labelEmail") }}
          </th>
          <th scope="col" class="fixed-width">
            {{ $t("admin.users.userManagement.labelRole") }}
          </th>
          <th scope="col" class="role">
            {{ $t("admin.users.userManagement.labelNotification") }}
          </th>
          <th scope="col" class="action"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in users" :key="index">
          <td
            :data-label="$t('admin.users.userManagement.labelName')"
            class="fixed-width"
          >
            {{ user.firstname }} {{ user.lastname }}
          </td>
          <td
            :data-label="$t('admin.users.userManagement.labelEmail')"
            class="fixed-width"
          >
            {{ user.email }}
          </td>
          <td
            :data-label="$t('admin.users.userManagement.labelRole')"
            class="fixed-width"
          >
            {{
              user.role === "superadmin"
                ? $t("admin.users.userManagement.roleSuperAdminLabel")
                : $t("admin.users.userManagement.roleAdminLabel")
            }}
          </td>
          <td
            :data-label="$t('admin.users.userManagement.labelNotification')"
            class="fixed-width"
          >
            <i
              :title="$t('layout.dashboardLayout.labelNotification')"
              v-if="user.notification"
              class="ri-notification-line"
            ></i>
          </td>
          <td class="action">
            <div class="action-alignment">
              <i
                class="ri-pencil-fill space click-icon"
                @click="editUser(user.id)"
                :title="$t('admin.users.userManagement.editTitle')"
              ></i>
              <i
                @click="deleteUser(user.id)"
                class="ri-delete-bin-line click-icon"
                :title="$t('admin.users.userManagement.deleteTitle')"
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
      @size-change="handleSizeChange"
      @current-change="setPage"
    >
    </el-pagination>
  </div>
</template>

<script setup lang="ts">
import type { Ref } from "vue";
import { reactive, ref } from "vue";
import { onMounted } from "@vue/runtime-core";
import { userService } from "../../../client/services/userService";
import { useI18n } from "vue-i18n";
import type { User, UserTable } from "../../../client";
import router from "../../../router";
import { ElMessage, ElMessageBox } from "element-plus";
import { useAuthStore } from "../../../store";

const authStore = useAuthStore();
const i18nLocale = useI18n();
const { t } = useI18n();
const users: Ref<User[]> = ref([]);
const tableData = reactive({
  search: "",
  page: 1,
  pageSize: 20,
  total: 0,
  pageCount: 0,
});

const state = reactive({
  loading: false,
  errorMsg: "",
});

onMounted(() => {
  getAllUsers();
});

const searchValue = () => {
  setTimeout(() => {
    getAllUsers();
  }, 1000);
};

const createUser = () => {
  router.push({ name: "create_user" });
};

const editUser = (userId: number) => {
  router.push({ name: "edit_user", params: { user_id: userId } });
};

const setPage = (val: number) => {
  tableData.page = val;
  getAllUsers();
};

const handleSizeChange = (val: number) => {
  tableData.pageSize = val;
  getAllUsers();
};

const getAllUsers = () => {
  userService
    .getAll(i18nLocale.locale.value, tableData.page, tableData.pageSize, tableData.search)
    .then((user: UserTable) => {
      users.value = user.data;
      if (user.meta) {
        tableData.pageCount = user.meta?.last_page;
        tableData.total = user.meta?.total;
      }
    })
    .catch((error) => {
      state.loading = false;
      state.errorMsg = error.data.message;
    });
};

const deleteUser = (userId: number) => {
    if(authStore.me?.id !== userId)
    {
        ElMessageBox.confirm(
        t("admin.users.list.deleteUserWarning.message"),
        t("admin.users.list.deleteUserWarning.title"),
        {
        confirmButtonText: t("admin.users.list.deleteConfirmButtonText"),
        cancelButtonText: t("admin.users.list.deleteCancelButtonText"),
        type: "warning",
        }
        ).then(() => {
            userService
            .delete(userId)
            .then(() => {
                getAllUsers();
                ElMessage({
                type: "success",
                message: t("admin.users.list.userDeleteSuccessMsg"),
                });
            })
            .catch((error) => {
                ElMessage({
                type: "error",
                message: t("admin.users.list.userDeleteErrorMsg"),
                });
            });
        });
    }
    else{
        ElMessage({
        type: "error",
        message: t("admin.users.list.adminItSelfDeleteMessage"),
        });
    }
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
.right-pagination {
  justify-content: flex-end;
}

.search {
  max-width: 170px;
}
.table-head {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.action-alignment {
  display: flex;
  align-items: end;
  justify-content: end;
}
</style>
