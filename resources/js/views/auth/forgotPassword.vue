<template>
  <div class="main-view">
    <div class="auth-layout">
      <h1 class="title side-green-dot-bar">{{ $t("auth.forgotPassword.title") }}</h1>
      <el-form
        require-asterisk-position="right"
        :model="forgotPassForm"
        ref="forgotPassFormRef"
        :rules="rules"
        label-position="top"
      >
        <el-form-item :label="$t('auth.forgotPassword.labelInputEmail')" prop="email">
          <el-input
            size="large"
            type="email"
            v-model="forgotPassForm.email"
            :placeholder="$t('auth.forgotPassword.emailPlaceholder')"
          />
        </el-form-item>
        <span v-show="state.errorMsg" class="error-authform">{{ state.errorMsg }}</span>

        <div class="btactions">
          <RouterLink class="link" :to="{ name: 'login' }">{{
            $t("auth.forgotPassword.loginButtonText")
          }}</RouterLink>
          <el-button
            @click="forgotFormSubmit(forgotPassFormRef)"
            block
            :loading="state.loading"
            :disabled="state.loading"
            type="primary"
          >
            {{ $t("auth.forgotPassword.sendResetPasswordLinkButtonText") }}
          </el-button>
        </div>
      </el-form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import type { Auth_Forgot } from "../../client";
import type { FormInstance, FormRules } from "element-plus";
import { authService } from "../../client";
import { ElNotification } from "element-plus";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const i18nLocale = useI18n();
const forgotPassFormRef = ref<FormInstance>();

const state = reactive({
  loading: false,
  errorMsg: "",
});

const forgotPassForm: Auth_Forgot = reactive({
  email: "",
});

const rules = reactive<FormRules>({
  email: [
    {
      type: "email",
      message: t("validation_messages.email"),
      trigger: "blur",
    },
    {
      required: true,
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],
});

const forgotFormSubmit = (formEl: FormInstance | undefined) => {
  if (!formEl) {
    return;
  }
  formEl.validate((valid) => {
    if (valid) {
      state.loading = true;
      authService
        .sendPasswordResetLink(forgotPassForm.email, i18nLocale.locale.value)
        .then(() => {
          state.errorMsg = "";
          state.loading = false;
          ElNotification({
            title: t("auth.forgotPassword.successTitle"),
            message: t("auth.forgotPassword.successMessage"),
            type: "success",
          });
          formEl.resetFields();
        })
        .catch((error) => {
          state.loading = false;
          state.errorMsg = error.email[0];
        });
    }
  });
};
</script>
