<template>
    <div class="main-view">
      <div class="layout_margin">
        <div class="title">
          <h1>{{ $t("admin.profileSetting.titleCreate") }}</h1>
        </div>
        <el-form
          require-asterisk-position="right"
          :model="createUser"
          ref="createUserRef"
          :rules="rules"
          label-position="top"
          class="editUserLayout"
        >
          <div class="column">
            <el-form-item
              class="error-space"
              :label="$t('admin.profileSetting.labelInputFirstName')"
              prop="firstname"
            >
              <el-input
                size="large"
                type="text"
                v-model="createUser.firstname"
                :placeholder="$t('admin.profileSetting.placeholderInputFirstName')"
              />
            </el-form-item>
            <el-form-item
              class="error-space"
              :label="$t('admin.profileSetting.labelInputLastName')"
              prop="lastname"
            >
              <el-input
                size="large"
                type="text"
                v-model="createUser.lastname"
                :placeholder="$t('admin.profileSetting.placeholderInputLastName')"
              />
            </el-form-item>
            <el-form-item
              class="error-space"
              :label="$t('admin.profileSetting.labelInputEmail')"
              prop="email"
            >
              <el-input
                size="large"
                type="email"
                v-model="createUser.email"
                :placeholder="$t('admin.profileSetting.placeholderInputEmail')"
              />
            </el-form-item>
            <el-form-item
              :label="$t('admin.profileSetting.labelInputPassword')"
              prop="password"
            >
              <el-input
                size="large"
                type="password"
                v-model="createUser.password"
                :placeholder="$t('admin.profileSetting.placeholderInputPassword')"
              />
              <p class="password-tag">
                {{ $t("admin.profileSetting.passwordResetText") }}
              </p>
            </el-form-item>
          </div>
        </el-form>
        <div class="error-message">
          <span v-show="createUserState.errorMsg">{{ createUserState.errorMsg }}</span>
        </div>
        <div class="btactions">
          <div class="saveOrCancelButtons">
            <el-button
              :loading="createUserState.loading"
              :disabled="createUserState.loading"
              class="primary"
              @click="saveUser(createUserRef)"
            >
              {{ $t("admin.profileSetting.saveButtonText") }}
            </el-button>
            <el-button class="space-left" @click="cancelEditOrCreate">
              {{ $t("admin.profileSetting.cancelButtonText") }}
            </el-button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { onBeforeMount, reactive, ref } from "vue";
  import type { Ref } from "vue";
  import type { User } from "../../client";
  import { useRoute } from "vue-router";
  import { userService } from "../../client/services/userService";
  import router from "../../router";
  import type { FormInstance, FormRules } from "element-plus";
  import { ElNotification } from "element-plus";
  import { useI18n } from "vue-i18n";
  import { useAuthStore } from "../../store";

  const i18nLocale = useI18n();
  const { t } = useI18n();
  const route = useRoute();
  const authStore = useAuthStore();
  const createUserRef = ref<FormInstance>();

  const createUser: Ref<User> = ref({
    id: 0,
    email: "",
    role: "admin",
  });

  const createUserState = reactive({
    edit: false,
    errorMsg: "",
    loading: false,
  });

  const rules = reactive<FormRules>({
    firstname: [
      {
        required: true,
        message: t("validation_messages.required"),
        trigger: "blur",
      },
    ],
    lastname: [
      {
        required: true,
        message: t("validation_messages.required"),
        trigger: "blur",
      },
    ],
    email: [
      {
        required: true,
        message: t("validation_messages.required"),
        trigger: "blur",
      },
      {
        type: "email",
        message: t("validation_messages.email"),
        trigger: "blur",
      },
    ],
    password: [
      { min: 8, message: t("validation_messages.minLength", { min: 8 }) },
    ],
  });

  onBeforeMount(() => {
    if (authStore.me?.id) {
      getUser(Number(authStore.me?.id));
    }
  });

  const getUser = (id: number) => {
    userService
      .get(id, i18nLocale.locale.value)
      .then((user: User) => {
        createUser.value = user;
      })
      .catch((error) => {
        createUserState.errorMsg = error.data.message;
        if (error.status === 404) {
          router.go(-1);
        }
      });
  };

  const saveUser = (formEl: FormInstance | undefined) => {
    if (authStore.me?.id !== undefined) {
      createUserState.errorMsg = "";
      if (!formEl) {
        return;
      }
      formEl.validate((valid) => {
        if (valid && authStore.me?.id) {
          createUserState.loading = true;
          let formData = new FormData();
          let userId = authStore.me?.id;
          Object.entries(createUser.value).forEach(([key, value]) => {
            if (key === "notification") {
              if (value === true) {
                value = "1";
              } else {
                value = "0";
              }
            }
            formData.append(key, value ? value.toString() : "");
          });
          if (createUser.value.password == "") {
            formData.delete("password");
          }
          formData.append("_method", "put");
          userService
            .update(formData, userId, i18nLocale.locale.value)
            .then((response: User) => {
              createUserState.loading = false;
              //for updating notification icon in header
              //if user edit himself then update icon
              if (response.id === authStore.me?.id) {
                authStore.setUser(response);
              }
              ElNotification({
                title: t("admin.profileSetting.updateSuccessTitle"),
                message: t("admin.profileSetting.updateSuccessMsg"),
                type: "success",
              });
            })
            .catch((error) => {
              createUserState.loading = false;
              createUserState.errorMsg = error.data.message;
            });
        }
      });
    }
  };

  const cancelEditOrCreate = () => {
    router.go(-1);
  };
  </script>

  <style lang="scss">
  @use "../../assets/scss/colors.scss" as *;
  .el-radio__input.is-checked .el-radio__inner {
    border-color: $darkgray !important;
    background-color: $primary !important ;
  }
  .el-radio {
    --el-radio-text-color: $white !important;
  }
  .el-select {
    width: 100%;
  }

  .el-date-editor.el-input {
    width: 100%;
  }
  .el-switch.is-checked .el-switch__core {
    background-color: $primary !important;
  }

  .space-top {
    margin-left: 20px;
  }

  .column {
    width: 50%;
  }
  .column-two {
    width: 50%;
  }

  .title-user {
    padding-bottom: 2.45rem;
  }

  @media screen and (max-width: 600px) {
    .space-top {
      margin-top: 20px;
      margin-left: 0px;
    }

    .title-user {
      padding-bottom: 0rem;
    }

    .editUserLayout {
      display: block !important;
    }

    .column {
      width: 100%;
    }

    .column-two {
      width: 100%;
    }
  }
  </style>
  <style lang="scss" scoped>
  @use "../../assets/scss/colors.scss" as *;
  .btactions {
    display: flex;
    justify-content: space-between;
  }

  @media screen and (max-width: 425px) {
    .btactions {
      display: flex;
      justify-content: space-between;
      max-width: 100%;
    }
  }
  .primary {
    background-color: $primary;
    color: $white;
  }

  .editUserLayout {
    display: flex;
    flex-direction: row;
  }

  .password-tag {
    font-style: italic;
    color: grey;
  }

  p {
    display: block;
    margin-block-start: 0px !important;
    margin-block-end: 0px !important;
    margin-inline-start: 0px !important;
    margin-inline-end: 0px !important;
  }

  .error-message {
    margin-bottom: 10px;
    color: $error;
  }
  </style>
