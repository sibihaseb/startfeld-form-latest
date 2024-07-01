<template>
  <el-form-item
    :label="
      i18nLocale.locale.value === 'de' ? question.title.name.de : question.title.name.en
    "
  >
    <div class="edit_option" v-if="formbuild">
      <div>
        <p v-if="question.description">
          {{
            i18nLocale.locale.value === "de"
              ? question.description.name.de
              : question.description.name.en
          }}
        </p>
      </div>
      <div>
        <i class="ri-pencil-fill edit-color" @click="editquestion(question)"></i>
        <i class="ri-delete-bin-line delete-color" @click="deletequestion(question)"></i>
      </div>
    </div>
    <div class="only-description" v-if="formbuild === false">
      <p v-if="question.description">
        {{
          i18nLocale.locale.value === "de"
            ? question.description.name.de
            : question.description.name.en
        }}
      </p>
    </div>
    <div class="file">
      <el-upload
        :disabled="props.disable"
        v-model="allAnswer[0].value"
        :on-change="(uploadFile) => fileSubmit(uploadFile)"
        :limit="1"
        :auto-upload="false"
      >
        <template #trigger>
          <el-button type="primary">Upload</el-button>
        </template>
      </el-upload>
      <a
        v-if="allAnswer[0].value && typeof allAnswer[0].value !== 'object'"
        :href="SITEURL + '/storage/' + allAnswer[0].value?.toString()"
        download
        >{{ "File" + question.id }}</a
      >
    </div>
  </el-form-item>
</template>

<script setup lang="ts" name="fileUpload">
import type { Question, QuestionAnswer, QuestionCreate } from "../client";
import { onBeforeMount, Ref } from "vue";
import { ref } from "vue";
import { useI18n } from "vue-i18n";

const i18nLocale = useI18n();
const allQuestions: Ref<Question | undefined> = ref();
const allAnswer: Ref<QuestionAnswer[]> = ref([]);
const SITEURL = import.meta.env.VITE_APP_URL;
const props = defineProps({
  question: {
    required: true,
    type: Object as () => Question,
  },
  disable: {
    type: Boolean,
  },
  answerValue: {
    type: [String, File],
  },
  formbuild: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["fileSubmitted", "editFileQuestion", "deleteFileQuestion"]);

onBeforeMount(() => {
  if (props.question) {
    allQuestions.value = props.question;
  }
  if (props.answerValue) {
    allAnswer.value.push({
      question_id: props.question.id,
      value: props.answerValue,
    });
  } else {
    allAnswer.value.push({
      question_id: props.question.id,
    });
  }
});

const fileSubmit = (uploadFile) => {
  allAnswer.value[0].value = uploadFile.raw;
  emit("fileSubmitted", allAnswer.value[0]);
};

const editquestion = (question: Question) => {
  emit("editFileQuestion", question);
};

const deletequestion = (question: Question) => {
  emit("deleteFileQuestion", question);
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/colors";
.edit_option {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.edit-color {
  margin-right: 10px;
  cursor: pointer;
  color: $primary;
}

.delete-color {
  cursor: pointer;
  color: $error;
}

.only-description {
  margin-right: 40px;
}
</style>
