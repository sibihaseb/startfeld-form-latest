<template>
  <div class="applicant">
    <h3>{{ $t("wizard.mainContactDetail.title") }}</h3>
    <el-form require-asterisk-position="right" label-position="top">
      <div class="row">
        <el-form-item
          class="row-item"
          :label="$t('wizard.mainContactDetail.labelFirstname')"
        >
          <el-input
            :disabled="props.disable"
            type="text"
            v-model="props.saveProfile.firstname"
            :placeholder="$t('wizard.mainContactDetail.labelFirstname')"
          />
          <div class="el-form-item__error" v-if="v$.firstname.$error">
            <span class="error-msg">{{ v$.firstname.$errors[0].$message }}</span>
          </div>
        </el-form-item>
        <el-form-item
          class="row-item-2"
          :label="$t('wizard.mainContactDetail.labelSurname')"
        >
          <el-input
            type="text"
            :disabled="props.disable"
            v-model="props.saveProfile.surname"
            :placeholder="$t('wizard.mainContactDetail.labelSurname')"
          />
          <div class="el-form-item__error" v-if="v$.surname.$error">
            <div class="error-msg">{{ v$.surname.$errors[0].$message }}</div>
          </div>
        </el-form-item>
      </div>
      <div class="row">
        <div class="row-item">
          <el-form-item :label="$t('wizard.mainContactDetail.labeladdress')">
            <el-input
              type="text"
              :disabled="props.disable"
              v-model="props.saveProfile.address"
              :placeholder="$t('wizard.mainContactDetail.labeladdress')"
            />
            <div class="el-form-item__error" v-if="v$.address.$error">
              <div class="error-msg">{{ v$.address.$errors[0].$message }}</div>
            </div>
          </el-form-item>
        </div>
        <div class="row-item-2">
          <div class="row">
            <div class="row-item">
              <el-form-item :label="$t('wizard.mainContactDetail.labelZip')">
                <el-input
                  type="text"
                  :disabled="props.disable"
                  v-model="props.saveProfile.zip"
                  :placeholder="$t('wizard.mainContactDetail.labelZip')"
                />
                <div class="el-form-item__error" v-if="v$.zip.$error">
                  <div class="error-msg">{{ v$.zip.$errors[0].$message }}</div>
                </div>
              </el-form-item>
            </div>
            <div class="row-item-2">
              <el-form-item :label="$t('wizard.mainContactDetail.labelCity')">
                <el-input
                  type="text"
                  :disabled="props.disable"
                  v-model="props.saveProfile.city"
                  :placeholder="$t('wizard.mainContactDetail.labelCity')"
                />
                <div class="el-form-item__error" v-if="v$.city.$error">
                  <div class="error-msg">{{ v$.city.$errors[0].$message }}</div>
                </div>
              </el-form-item>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="row-item">
          <el-form-item :label="$t('wizard.mainContactDetail.labelEmail')">
            <el-input
              type="text"
              :disabled="props.disable"
              v-model="props.saveProfile.email"
              :placeholder="$t('wizard.mainContactDetail.labelEmail')"
            />
            <div class="el-form-item__error" v-if="v$.email.$error">
              <div class="error-msg">{{ v$.email.$errors[0].$message }}</div>
            </div>
          </el-form-item>
        </div>
        <div class="row-item-2">
          <el-form-item :label="$t('wizard.mainContactDetail.labelTitle')">
            <el-input
              type="text"
              :disabled="props.disable"
              v-model="props.saveProfile.title"
              :placeholder="$t('wizard.mainContactDetail.labelTitle')"
            />
          </el-form-item>
        </div>
      </div>
      <div class="row">
        <div class="row-item">
          <el-form-item :label="$t('wizard.mainContactDetail.labelPhone')">
            <el-input
              type="text"
              :disabled="props.disable"
              v-model="props.saveProfile.phone"
              :placeholder="$t('wizard.mainContactDetail.labelPhone')"
            />
            <div class="el-form-item__error" v-if="v$.phone.$error">
              <div class="error-msg">{{ v$.phone.$errors[0].$message }}</div>
            </div>
          </el-form-item>
        </div>
        <div class="row-item-2">
          <el-form-item :label="$t('wizard.mainContactDetail.labelTraining')">
            <el-input
              type="text"
              :disabled="props.disable"
              v-model="props.saveProfile.training"
              :placeholder="$t('wizard.mainContactDetail.labelTraining')"
            />
          </el-form-item>
        </div>
      </div>
      <div class="row">
        <el-form-item :label="$t('wizard.mainContactDetail.labelCurrentStatus')">
          <el-radio-group
            v-model="props.saveProfile.current_status"
            :disabled="props.disable"
          >
            <el-radio :label="ApplicantCurrentStatus.employed">{{
              $t("wizard.mainContactDetail.labelEmployed")
            }}</el-radio>
            <el-radio :label="ApplicantCurrentStatus.unemployed">{{
              $t("wizard.mainContactDetail.labelUnemployed")
            }}</el-radio>
            <el-radio :label="ApplicantCurrentStatus.self_employed">{{
              $t("wizard.mainContactDetail.labelSelfEmployed")
            }}</el-radio>
            <el-radio :label="ApplicantCurrentStatus.other">{{
              $t("wizard.mainContactDetail.labelOther")
            }}</el-radio>
          </el-radio-group>
          <el-input
            :disabled="props.disable"
            v-if="props.saveProfile.current_status === ApplicantCurrentStatus.other"
            type="textarea"
            v-model="props.saveProfile.current_status_other"
            :placeholder="$t('wizard.mainContactDetail.labelOther')"
          />
          <div class="el-form-item__error" v-if="v$.current_status.$error">
            <div class="error-msg">{{ v$.current_status.$errors[0].$message }}</div>
          </div>
        </el-form-item>
        <div class="error-msg api-error" v-if="props.error">
          {{ props.error }}
        </div>
      </div>
    </el-form>
  </div>
</template>

<script setup lang="ts">
import type { ApplicantProfile } from "../client";
import { ApplicantCurrentStatus } from "../client";
import { required, email, maxLength } from "../plugins/i18n-validators";
import { useVuelidate } from "@vuelidate/core";

const props = defineProps({
  saveProfile: {
    required: true,
    type: Object as () => ApplicantProfile,
  },
  error: {
    type: String,
  },
  disable: {
    type: Boolean,
  },
});

const rules = {
  surname: { required, maxLength },
  firstname: { required, maxLength },
  address: { required, maxLength },
  zip: { required, maxLength },
  city: { required, maxLength },
  email: { required, email },
  phone: { required, maxLength },
  current_status: { required },
};
const v$ = useVuelidate(rules, props.saveProfile);

function validateFunction() {
  v$.value.$touch();
  return v$.value.$error;
}

defineExpose({ validateFunction });
</script>
<style lang="scss" scoped>
@use '../assets/scss/colors.scss' as *;
.applicant .el-form-item__error {
  margin-top: 2px;
}
.api-error {
  margin-bottom: 15px;
}
.error-msg {
  color: $error;
}
.row {
  display: flex;
  flex-direction: row;
}
.row-item {
  width: 50%;
}
.row-item-2 {
  margin-left: 10px;
  width: 50%;
}

@media screen and (max-width: 600px) {
  .row {
    display: flex;
    flex-direction: column;
  }
  .row-item {
    width: 100%;
  }
  .row-item-2 {
    width: 100%;
    margin-left: 0px;
  }
}
</style>
