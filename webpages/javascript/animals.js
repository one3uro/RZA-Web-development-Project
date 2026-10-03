// 1. Data store mapping select option values to content
const animalData = {
  lion: {
    title: "About the Lion",
    imgUrl: "../images/lion.jpg",
    description: "A highly social big cat that lives in family groups called prides on the African savanna. The males are known for their majestic manes, while the females do most of the hunting."
  },
  giraffe: {
    title: "About the Giraffe",
    imgUrl: "../images/giraffe.jpg",
    description: "The tallest land animal in the world, using its long neck to eat leaves from high treetop branches. They have unique spot patterns and long, blue-black tongues that protect against sunburn."
  },
  panda: {
    title: "About the Panda",
    imgUrl: "../images/panda.jpg",
    description: "A distinctive black-and-white bear from China that eats bamboo for up to 12 hours a day. They have a special pseudo-thumb bone that helps them hold and strip the stalks."
  },
  elephant: {
    title: "About the Elephant",
    imgUrl: "../images/elephant.jpg",
    description: "The largest land mammal on Earth, famous for its incredible intelligence and multi-purpose trunk. They live in tight family groups and communicate over long distances using low-frequency rumbles."
  }
};

// 2. Select DOM elements
const selectElement = document.getElementById("animals");
const imgElement = document.getElementById("animal-img");
const titleElement = document.getElementById("animal-title");
const descElement = document.getElementById("animal-desc");

// 3. Update view function
function updateAnimalDisplay(selectedKey) {
  const data = animalData[selectedKey];
  if (!data) return;

  imgElement.src = data.imgUrl;
  imgElement.alt = data.title;
  titleElement.textContent = data.title;
  descElement.textContent = data.description;
}

// 4. Trigger update when selection changes
selectElement.addEventListener("change", (event) => {
  updateAnimalDisplay(event.target.value);
});

// 5. Initialize default view on page load
updateAnimalDisplay(selectElement.value);