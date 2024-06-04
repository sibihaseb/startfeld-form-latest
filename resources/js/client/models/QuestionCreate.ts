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
    type: string;
    step: BigInteger;
    options?: string;
    minValue?: BigInteger;
    maxValue?: BigInteger;
    dateFormat?: Date;
    protocol?: URL;
};

