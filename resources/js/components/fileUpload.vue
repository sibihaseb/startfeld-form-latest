<template>
    <el-form-item
    :label="
      i18nLocale.locale.value === 'de'
        ? question.title.name.de
        : question.title.name.en">
    <p v-if="question.description">
      {{
        i18nLocale.locale.value === "de"
          ? question.description.name.de
          : question.description.name.en
      }}
    </p>
    <div class="file">
      <el-upload
        :disabled="props.disable"
        v-model="allAnswer[0].value"
        :on-change="
          (uploadFile) => (fileSubmit(uploadFile))
        "
        :limit="1"
        :auto-upload="false"
      >
        <template #trigger>
          <el-button type="primary">Upload</el-button>
        </template>
      </el-upload>
      <a
        v-if="
        allAnswer[0].value &&
        typeof allAnswer[0].value !== 'object'
        "
        :href="SITEURL +'/storage/' + allAnswer[0].value?.toString()"
        download
        >{{ "File" + question.id }}</a>
    </div>
  </el-form-item>
</template>

<script setup lang="ts" name="fileUpload">
import type { Question, QuestionAnswer } from "../client";
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
        type: Object as () => Question
    },
    disable:{
        type: Boolean
    },
    answerValue:{
        type: [String, File]
    }
});

const emit = defineEmits(["fileSubmitted"]);

onBeforeMount(() => {
  if(props.question)
  {
    allQuestions.value = props.question;
  }
  if(props.answerValue)
  {
    allAnswer.value.push({
        question_id: props.question.id,
        value: props.answerValue
    })
  }
  else{
  allAnswer.value.push({
    question_id: props.question.id,
  })
  }
});

const fileSubmit = (uploadFile) => {
    allAnswer.value[0].value = uploadFile.raw;
    emit("fileSubmitted", allAnswer.value[0]);
}

</script>

<style></style>

