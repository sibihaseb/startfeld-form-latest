/* istanbul ignore file */
/* tslint:disable */
/* eslint-disable */
import { DateTimeFormatResult } from 'vue-i18n';
import { QuestionAnswer } from './QuestionAnswer';
import type { QuestionAnswerType } from './QuestionAnswerType';
import type { QuestionOptions } from './QuestionOptions';
import { QuestionTranslated } from './QuestionTranslated';

export type QuestionCreate = {
    title: string;
    description: string;
    answer_type: string;
    step: any;
    is_mandatory: boolean;
    sort_order?: number;
    options?: string;
    minValue?: BigInteger;
    maxValue?: BigInteger;
    dateFormat?: Date;
    protocol?: URL;
};

