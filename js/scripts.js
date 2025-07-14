// Declaração e inicialização das variáveis
let currentSlide = 0;
let carouselItems = []; // Você precisará preencher isso com seus itens do carrossel
let intervalId;

// Seleciona os elementos do carrossel e os botões de navegação
// **Você precisa ajustar esses seletores de acordo com o seu HTML**
document.addEventListener('DOMContentLoaded', () => {
  carouselItems = document.querySelectorAll('.carousel-item'); // Exemplo: selecione todos os elementos com a classe 'carousel-item'
  const prevSlide = document.querySelector('.carousel-control-prev'); // Exemplo: selecione o botão de slide anterior
  const nextSlide = document.querySelector('.carousel-control-next'); // Exemplo: selecione o botão de próximo slide

  // Certifique-se de que há itens no carrossel antes de prosseguir
  if (carouselItems.length === 0) {
    console.warn("Nenhum item de carrossel encontrado. Verifique seus seletores.");
    return;
  }

  // Inicializa o carrossel
  updateCarousel();
  intervalId = setInterval(nextSlideAuto, 7000);

  function updateCarousel() {
    carouselItems.forEach((item, index) => {
      item.classList.remove('active');
      if (index === currentSlide) {
        item.classList.add('active');
      }
    });
  }

  function nextSlideAuto() {
    currentSlide++;
    if (currentSlide >= carouselItems.length) {
      currentSlide = 0;
    }
    updateCarousel();
  }

  if (prevSlide) {
    prevSlide.addEventListener('click', () => {
      clearInterval(intervalId);
      currentSlide--;
      if (currentSlide < 0) {
        currentSlide = carouselItems.length - 1;
      }
      updateCarousel();
      intervalId = setInterval(nextSlideAuto, 7000);
    });
  }

  if (nextSlide) {
    nextSlide.addEventListener('click', () => {
      clearInterval(intervalId);
      currentSlide++;
      if (currentSlide >= carouselItems.length) {
        currentSlide = 0;
      }
      updateCarousel();
      intervalId = setInterval(nextSlideAuto, 7000);
    });
  }
});