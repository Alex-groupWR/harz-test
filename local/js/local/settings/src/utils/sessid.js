export const getSessid = () => {
  if (
    typeof window !== 'undefined' &&
    window.BX &&
    typeof window.BX.bitrix_sessid === 'function'
  ) {
    return window.BX.bitrix_sessid();
  }

  if (typeof window !== 'undefined' && window.bitrixSessid) {
    return window.bitrixSessid;
  }

  console.warn('CSRF token not found');
  return null;
};
