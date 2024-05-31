<template>
    <div class="main-view">
        <div class="auth-layout">
            <h1 class="title side-green-dot-bar">{{ $t("auth.forgotPassword.title") }}</h1>
            <el-form require-asterisk-position="right" :model="forgotPassForm" ref="forgotPassFormRef" :rules="rules"
                label-position="top">
                <el-form-item :label="$t('auth.forgotPassword.labelInputEmail')" prop="email">
                    <el-input size="large" type="email" v-model="forgotPassForm.email"
                        :placeholder="$t('auth.forgotPassword.emailPlaceholder')" />
                </el-form-item>
                <span v-show="state.errorMsg" class="error-authform">{{ state.errorMsg }}</span>

                <div class="btactions">
                    <RouterLink class="link" :to="{ name: 'login' }">{{
                        $t("auth.forgotPassword.loginButtonText")
                        }}</RouterLink>
                    <el-button @click="forgotFormSubmit(forgotPassFormRef)" block :loading="state.loading"
                        :disabled="state.loading" type="primary">
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
<style lang="scss" scoped>
@use "../../assets/scss/colors.scss" as *;

.auth-layout {
    width: 30%;
    margin: auto;
    padding-block: 5rem;
    min-height: 50vh;
}

.auth-layout h1 {
    margin-bottom: 2rem;
    font-family: "GraphikRegular";
}

.el-form-item {
    font-family: "GraphikRegular";
}

.remember {
    display: flex;
    align-items: center;
}

.labelofRemember {
    font-family: "GraphikRegular";
    margin-right: 8px;
}

.btactions {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.link {
    text-decoration: none;
    font-family: "GraphikRegular";
    color: $text-color;
}

.el-button {
    border-color: $text-color;
    padding: 12px 24px;
    border: 2px solid $text-color;
    background-color: $text-color;
    border-radius: 4px;
    color: $white;
    font-family: "GraphikRegular";
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}
</style>
