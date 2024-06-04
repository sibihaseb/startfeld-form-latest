<template>
  <h4>{{ submittedSections }}</h4>

  <div class="applicant">
    <el-form :model="form" label-width="auto">
      <el-form-item label="Title">
        <el-input v-model="form.title" />
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="form.description" />
      </el-form-item>
      <el-form-item label="Type">
        <el-select
          v-model="form.type"
          placeholder="Please select field type"
          @change="handleTypeChange"
        >
          <el-option label="Text" value="text" />
          <el-option label="Radio" value="radio" />
          <el-option label="Checkbox" value="checkbox" />
          <el-option label="Number" value="number" />
          <el-option label="Email" value="email" />
          <el-option label="Date" value="date" />
          <el-option label="URL" value="url" />
        </el-select>
      </el-form-item>
  <!-- <el-form-item label="Steps">
    <el-select v-model="currentStep" placeholder="Please select steps">
      <el-option
        v-for="(section, index) in props.step"
        :key="index"
        :label="`Step ${index + 1}`"  :value="section.step || index + 1"  />
    </el-select>
  </el-form-item> -->
<el-form-item label="Steps">
    <el-select v-model="currentStep" placeholder="Please select steps">
      <el-option
        v-for="(section, index) in props.step"
        :key="index"
        :label="index === 0 ? 'Step 1' : `Step ${index + 1}`"  :value="section.step || index + 1"
      />
    </el-select>
  </el-form-item>

      <!-- Additional fields based on selected type -->
      <template v-if="form.type === 'radio' || form.type === 'checkbox'">
        <el-form-item label="Options">
          <el-input
            v-model="form.options"
            placeholder="Enter options separated by commas"
          />
        </el-form-item>
      </template>
      <template v-if="form.type === 'number'">
        <el-form-item label="Min Value">
          <el-input v-model="form.minValue" placeholder="Enter minimum value" />
        </el-form-item>
        <el-form-item label="Max Value">
          <el-input v-model="form.maxValue" placeholder="Enter maximum value" />
        </el-form-item>
      </template>
      <template v-if="form.type === 'date'">
        <el-form-item label="Date Format">
          <div class="demo-datetime-picker">
            <div class="block">
              <el-date-picker
                v-model="dateTime"
                type="datetime"
                placeholder="Pick a Date"
                format="YYYY/MM/DD HH:mm:ss"
              />
            </div>
          </div>
        </el-form-item>
      </template>
      <template v-if="form.type === 'url'">
        <el-form-item label="Protocol">
          <el-input v-model="form.protocol" placeholder="Enter protocol" />
        </el-form-item>
      </template>

      <el-form-item>
        <el-button type="primary" @click="onSubmit">Save</el-button>
        <el-button @click="cancelSection">Cancel</el-button>
      </el-form-item>
    </el-form>
    <h4>{{ currentSection }}</h4>
  </div>
</template>

<script setup lang="ts" name="addField">
import { reactive } from "vue";
import { defineProps, defineEmits } from "vue";
import { ref } from "vue";

const emit = defineEmits();
const dateTime = ref("");
const stepOptions = ref([]);

const props = defineProps({
  step: Array,
  stepOptions: Array,
});
console.log(props.step); // this works

const form = reactive({
  title: "",
  description: "",
  type: "",
  step: "",
  options: "",
  minValue: "",
  maxValue: "",
  dateFormat: "",
  protocol: "",
});

const cancelSection = () => {
  emit("cancel");
};
let initialSubmissions = ref(2);
const currentStep = ref(1);
const onSubmit = () => {
  console.log("submit!");
  emit("submit", form);
  if (initialSubmissions.value > 0) {
    initialSubmissions.value--; // Decrement initialSubmissions for the first two times
  } else {
    currentStep.value++; // Increment step for subsequent submissions
  }
};

const handleTypeChange = () => {
  // Reset additional fields when type changes
  form.options = "";
  form.minValue = "";
  form.maxValue = "";
  form.dateFormat = "";
  form.protocol = "";
};
</script>
