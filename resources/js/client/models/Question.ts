/* istanbul ignore file */
/* tslint:disable */
/* eslint-disable */
import { QuestionAnswer } from './QuestionAnswer';
import type { QuestionAnswerType } from './QuestionAnswerType';
import type { QuestionOptions } from './QuestionOptions';
import { QuestionTranslated } from './QuestionTranslated';

export type Question = {
    id: number;
    step: number;
    sort_order: number;
    title: QuestionTranslated;
    description?: QuestionTranslated,
    is_hidden: boolean;
    is_mandatory: boolean;
    answer_type?: QuestionAnswerType;
    options?: QuestionOptions;
    answer?: QuestionAnswer;
};

