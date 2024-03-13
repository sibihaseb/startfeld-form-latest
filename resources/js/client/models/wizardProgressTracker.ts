import { StepError } from "./StepError";

export type WizardProgressTracker = {
    activeStepNo: number,
  totalStep: number,
  errorStep: StepError[],
}
