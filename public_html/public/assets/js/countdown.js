const secEle = document.querySelector('.countdown-section');
if(secEle){
  const dateStringFormat = secEle.getAttribute('data-event-date');

  // 23:59:59
  const targetDate = new Date(dateStringFormat+"T00:00:00").getTime();
  
  function updateCountdown() {
    const now = new Date().getTime();
    const timeLeft = targetDate - now;
  
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
  
    document.getElementById("days").textContent = days < 10 ? "0" + days : days;
    document.getElementById("hours").textContent = hours < 10 ? "0" + hours : hours;
    document.getElementById("minutes").textContent = minutes < 10 ? "0" + minutes : minutes;
    document.getElementById("seconds").textContent = seconds < 10 ? "0" + seconds : seconds;
  }
  
  updateCountdown();
  setInterval(updateCountdown, 1000);
  
  
    //  jQuery(document).ready(function($) {
    //     $('.counter').counterUp({
    //         delay: 10,
    //         time: 1000
    //     });      
    // });
}