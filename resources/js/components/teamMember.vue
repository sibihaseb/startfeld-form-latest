<template>
  <h3>{{ $t("wizard.mainContactDetail.lableTeamMember") + " " + (memberIndex + 1) }}</h3>
  <el-form require-asterisk-position="right" label-position="top">
    <div class="row">
      <div class="row-item">
        <el-form-item :label="$t('wizard.mainContactDetail.labelFirstname')">
          <el-input
            type="text"
            :disabled="props.disable"
            v-model="teamMemberProfileData.firstname"
            :placeholder="$t('wizard.mainContactDetail.labelFirstname')"
          />
        </el-form-item>
      </div>
      <div class="row-item-2">
        <el-form-item :label="$t('wizard.mainContactDetail.labelSurname')">
          <el-input
            type="text"
            :disabled="props.disable"
            v-model="teamMemberProfileData.surname"
            :placeholder="$t('wizard.mainContactDetail.labelSurname')"
          />
        </el-form-item>
      </div>
    </div>
    <div class="row">
      <div class="row-item">
        <el-form-item :label="$t('wizard.mainContactDetail.labeladdress')">
          <el-input
            type="text"
            :disabled="props.disable"
            v-model="teamMemberProfileData.address"
            :placeholder="$t('wizard.mainContactDetail.labeladdress')"
          />
        </el-form-item>
      </div>
      <div class="row-item-2">
        <div class="row">
          <div class="row-item">
            <el-form-item :label="$t('wizard.mainContactDetail.labelZip')">
              <el-input
                type="text"
                :disabled="props.disable"
                v-model="teamMemberProfileData.zip"
                :placeholder="$t('wizard.mainContactDetail.labelZip')"
              />
            </el-form-item>
          </div>
          <div class="row-item-2">
            <el-form-item :label="$t('wizard.mainContactDetail.labelCity')">
              <el-input
                type="text"
                :disabled="props.disable"
                v-model="teamMemberProfileData.city"
                :placeholder="$t('wizard.mainContactDetail.labelCity')"
              />
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
            v-model="teamMemberProfileData.email"
            :placeholder="$t('wizard.mainContactDetail.labelEmail')"
          />
          <div class="input-errors" v-if="v$.email.$error">
            <div class="error-msg">{{ v$.email.$errors[0].$message }}</div>
          </div>
        </el-form-item>
      </div>
      <div class="row-item-2">
        <el-form-item :label="$t('wizard.mainContactDetail.labelTitle')">
          <el-input
            type="text"
            :disabled="props.disable"
            v-model="teamMemberProfileData.title"
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
            v-model="teamMemberProfileData.phone"
            :placeholder="$t('wizard.mainContactDetail.labelPhone')"
          />
        </el-form-item>
      </div>
      <div class="row-item-2">
        <el-form-item :label="$t('wizard.mainContactDetail.labelTraining')">
          <el-input
            type="text"
            :disabled="props.disable"
            v-model="teamMemberProfileData.training"
            :placeholder="$t('wizard.mainContactDetail.labelTraining')"
          />
        </el-form-item>
      </div>
    </div>
    <div class="row">
      <div class="row-item">
        <el-form-item :label="$t('wizard.mainContactDetail.labelCurrentStatus')">
          <el-radio-group
            v-model="teamMemberProfileData.current_status"
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
            v-if="teamMemberProfileData.current_status === ApplicantCurrentStatus.other"
            :disabled="props.disable"
            type="textarea"
            v-model="teamMemberProfileData.current_status_other"
            :placeholder="$t('wizard.mainContactDetail.labelOther')"
          />
          <div class="input-errors" v-if="v$.current_status.$error">
            <div class="error-msg">{{ v$.current_status.$errors[0].$message }}</div>
          </div>
        </el-form-item>
        <div class="error-msg api-error" v-if="props.error">
          {{ props.error }}
        </div>
      </div>
    </div>
  </el-form>
</template>

<script setup lang="ts">
import { TeamMemberProfile } from "../client";
import { useVuelidate } from "@vuelidate/core";
import { ApplicantCurrentStatus } from "../client";
import { required, email } from "../plugins/i18n-validators";

const props = defineProps({
  teamMemberProfileData: {
    required: true,
    type: (Object as () => TeamMemberProfile) || undefined,
    default: () => [],
  },
  memberIndex: {
    required: true,
    type: Number || undefined,
    default: () => 0,
  },
  error: {
    type: String,
  },
  disable: {
    type: Boolean,
  },
  // for team Memberscope
  //   scope: {
  //     type: String,
  //   }
});

const rules = {
  email: { email },
  current_status: { required },
};

const v$ = useVuelidate(rules, props.teamMemberProfileData);

// for validating teamMembers separately
// const v$ = useVuelidate(rules, props.teamMemberProfileData, {
//   $scope: props.scope});

function resetFormFeilds() {
  v$.value.$reset();
}

function validateFunction() {
  v$.value.$touch();
  return v$.value.$error;
}

defineExpose({ validateFunction, resetFormFeilds });
</script>

<style lang="scss" scoped>
@use '../assets/scss/colors.scss' as *;
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
