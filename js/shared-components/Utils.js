/**
 * Get cookie function
 */
export function getCookie(name) {
   var cookieValue = null;
   if (document.cookie && document.cookie !== '') {
       var cookies = document.cookie.split(';');
       for (var i = 0; i < cookies.length; i++) {
           var cookie = cookies[i].replace(/^\s+|\s+$/gm,'');
           if (cookie.substring(0, name.length + 1) === (name + '=')) {
               cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
               break;
           }
       }
   }
   return cookieValue;
}

export function showButton() {
  let showBtn = document.createElement("div");
  showBtn.className = "show-comments-btn";
  showBtn.innerHTML = `
    <div class="comments-btn-text">Load more</div>
    <img class="comments-btn-arrow" alt="" src="/assets/images/arrow-down.svg">
  `;

  return showBtn;
}
