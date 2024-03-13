import { StepError } from "./StepError";

export type StepDetailProcess = {
    activeStepNo: number;
    totalStep: number;
    errorStep: Array<StepError>;
};
