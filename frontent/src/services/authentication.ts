export function isMentorAuthenticated() {
  return localStorage.getItem('access_token') || sessionStorage.getItem('access_token')
    ? true
    : false;
}

export function getMentorToken() {
  return localStorage.getItem('access_token') ?? sessionStorage.getItem('access_token');
}

export function resetStorage() {
  localStorage.removeItem('access_token');
  localStorage.removeItem('mentor_name');
  localStorage.removeItem('mentor_role');
  sessionStorage.removeItem('access_token');
}
