export function getBaseUrl() {
  const meta = document.querySelector('meta[name="base-url"]');
  if (!meta) {
    throw new Error('Meta base-url tidak ditemukan');
  }
  return meta.getAttribute('content');
}

export function getRole() {
  const meta = document.querySelector('meta[name="role"]');
  if (!meta) {
    throw new Error('Meta role tidak ditemukan');
  }
  return meta.getAttribute('content');
}
