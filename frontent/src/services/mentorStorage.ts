export function setLocalMentorData(response: any) {
  localStorage.setItem('mentor_name', response.data.mentor_name);
  localStorage.setItem('mentor_role', response.data.mentor_role);
}
