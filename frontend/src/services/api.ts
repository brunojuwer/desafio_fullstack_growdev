import axios from 'axios';
import { getMentorToken } from './authentication';
import type { MentorType } from '@/types';

const client = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: 'application/json'
  }
});

export const login = async (email: string, password: string) => {
  try {
    const response = await client.post('/login', {
      email,
      password
    });
    return response;
  } catch (error: any) {
    return error?.response;
  }
};

export async function logout() {
  const config = {
    headers: { Authorization: `Bearer ${getMentorToken()}` }
  };
  try {
    return await client.delete('/logout', config);
  } catch (error: any) {
    return error?.reponse;
  }
}

export async function register(mentor: MentorType) {
  try {
    const config = {
      headers: { Authorization: `Bearer ${getMentorToken()}` }
    };
    return await client.post('/mentors', mentor, config);
  } catch (error: any) {
    return error?.response;
  }
}

export async function update(mentor: MentorType) {
  try {
    const config = {
      headers: { Authorization: `Bearer ${getMentorToken()}` }
    };
    return await client.put(`/mentors/${mentor.id}`, mentor, config);
  } catch (error: any) {
    return error?.response;
  }
}

export async function retrieveMentors(query: string) {
  const config = {
    headers: { Authorization: `Bearer ${getMentorToken()}` }
  };
  try {
    const response = await client.get(`/mentors${query}`, config);
    return response;
  } catch (error: any) {
    return error?.response;
  }
}

export async function destroy(id: string | undefined) {
  const config = {
    headers: { Authorization: `Bearer ${getMentorToken()}` }
  };
  try {
    return await client.delete(`/mentors/${id}`, config);
  } catch (error: any) {
    return error?.response;
  }
}
