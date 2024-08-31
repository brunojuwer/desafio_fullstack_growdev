import type { LoginMentorValidationType } from '@/types';
import { reactive } from 'vue';

export const validationErrors = reactive<LoginMentorValidationType>({
  email: [],
  password: []
});

export function setValidationErrors(errors: any) {
  for (const key in validationErrors) {
    validationErrors[key as keyof LoginMentorValidationType] = errors[key];
  }
}
export function clearValidationErrors() {
  for (const key in validationErrors) {
    validationErrors[key as keyof LoginMentorValidationType] = [];
  }
}
