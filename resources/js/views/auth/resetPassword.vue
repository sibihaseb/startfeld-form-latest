<template>
  <div class="main-view">
    <div class="auth-layout">
      <h1 class="title side-pink-dot-bar">{{ $t("auth.resetPassword.title") }}</h1>
      <el-form
        require-asterisk-position="right"
        :model="resetPassForm"
        ref="resetPassFormRef"
        :rules="rules"
        label-position="top"
      >
        <el-form-item :label="$t('auth.resetPassword.labelInputEmail')" prop="email">
          <el-input
            size="large"
            type="email"
            v-model="resetPassForm.email"
            :placeholder="$t('auth.resetPassword.emailPlaceholder')"
          />
        </el-form-item>
        <el-form-item
          :label="$t('auth.resetPassword.labelInputPassword')"
          prop="password"
        >
          <el-input
            size="large"
            type="password"
            v-model="resetPassForm.password"
            :placeholder="$t('auth.resetPassword.passwordPlaceholder')"
          />
        </el-form-item>
        <el-form-item
          :label="$t('auth.resetPassword.labelInputPasswordConfirmation')"
          prop="password_confirmation"
        >
          <el-input
            size="large"
            type="password"
            v-model="resetPassForm.password_confirmation"
            :placeholder="$t('auth.resetPassword.passwordConfirmPlaceholder')"
          />
        </el-form-item>
        <span v-show="state.errorMsg" class="error-loginform">{{ state.errorMsg }}</span>

        <div class="btactions">
          <RouterLink class="link" :to="{ name: 'login' }">{{
            $t("auth.resetPassword.loginButtonText")
          }}</RouterLink>
          <el-button
            @click="resetFormSubmit(resetPassFormRef)"
            block
            :loading="state.loading"
            :disabled="state.loading"
            type="primary"
          >
            {{ $t("auth.resetPassword.resetPasswordButtonText") }}
          </el-button>
        </div>
      </el-form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from "vue";
import type { FormInstance, FormRules } from "element-plus";
import { authService } from "../../client/services/authService";
import { ElNotification } from "element-plus";
import router from "../../router/index";
import { useI18n } from "vue-i18n";
import { Auth_Reset_Password } from "../../client/models/auth_reset_password";
import { useRoute } from "vue-router";

const { t } = useI18n();
const route = useRoute();
const i18nLocale = useI18n();
const resetPassFormRef = ref<FormInstance>();
const token = String(route.params.token);

const state = reactive({
  loading: false,
  errorMsg: "",
});

const resetPassForm: Auth_Reset_Password = reactive({
  email: "",
  password: "",
  password_confirmation: "",
  token: "",
});

const validatePass = (rule: any, value: any, callback: any) => {
  if (value === "") {
    callback(new Error(t("validation_messages.password")));
  } else {
    if (resetPassForm.password_confirmation !== "") {
      if (!resetPassFormRef.value) return;
      resetPassFormRef.value.validateField("passwordconfirm", () => null);
    }
    callback();
  }
};
const validatePass2 = (rule: any, value: any, callback: any) => {
  if (value === "") {
    callback(new Error(t("validation_messages.passwordReEnter")));
  } else if (value !== resetPassForm.password) {
    callback(new Error(t("validation_messages.sameAsPass")));
  } else {
    callback();
  }
};

const rules = reactive<FormRules>({
  email: [
    {
      required: true,
      type: "email",
      message: t("validation_messages.required"),
      trigger: "blur",
    },
  ],
  password: [
    {
      validator: validatePass,
      required: true,
      trigger: "blur",
      message: t("validation_messages.required"),
    },
    { min: 8, message: t("validation_messages.minLength", { min: 8 }) },
  ],
  password_confirmation: [
    {
      validator: validatePass2,
      required: true,
      trigger: "blur",
      message: t("validation_messages.sameAsPass"),
    },
  ],
});

const resetFormSubmit = (formEl: FormInstance | undefined) => {
  if (!formEl) {
    return;
  }
  formEl.validate((valid) => {
    if (valid) {
      resetPassForm.token = token;
      state.loading = true;
      authService
        .resetPassword(resetPassForm, i18nLocale.locale.value)
        .then(() => {
          state.loading = false;
          ElNotification({
            title: t("auth.resetPassword.resetPasswordSuccessTitle"),
            message: t("auth.resetPassword.resetPasswordSuccessMsg"),
            type: "success",
          });
          formEl.resetFields();
          router.push({ name: "login" });
        })
        .catch((error) => {
          state.loading = false;
          state.errorMsg = error.email[0];
        });
    }
  });
};
</script>
