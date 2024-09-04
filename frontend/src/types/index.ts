export interface MentorType {
  id?: string;
  name: string;
  email: string;
  cpf: string;
  password?: string;
  role?: 'ADMIN' | 'VIEWER';
}

export interface DefaultValidationType {}

export interface RegisterMentorValidationType {
  name: [];
  email: [];
  cpf: [];
  password?: [];
  role?: [];
}

export interface LoginMentorValidationType extends DefaultValidationType {
  email: [];
  password: [];
}
