// document.addEventListener("DOMContentLoaded", function () {
//     let searchInput = document.getElementById("search-input");
//     let resultsContainer = document.getElementById("search-results");
//     let resultsList = document.getElementById("results-list");

//     searchInput.addEventListener("keyup", function () {
//         let query = this.value.trim();

//         if (query.length > 1) {
//             fetch(`/search?query=${encodeURIComponent(query)}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     resultsList.innerHTML = "";

//                     if (data.length > 0) {
//                         data.forEach(product => {
//                             let listItem = document.createElement("li");
//                             listItem.classList.add("p-2", "border-b", "hover:bg-gray-100", "cursor-pointer", "flex", "items-center");

//                             listItem.innerHTML = `
//                                 <img src="${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded-md mr-3">
//                                 <div>
//                                     <p class="text-gray-800 font-medium">${product.name}</p>
//                                     <p class="text-gray-600 text-sm">₱${parseFloat(product.price).toFixed(2)}</p>
//                                 </div>
//                             `;

//                             listItem.addEventListener("click", function () {
//                                 window.location.href = `/products/${product.product_id}`;
//                             });

//                             resultsList.appendChild(listItem);
//                         });

//                         resultsContainer.classList.remove("hidden");
//                     } else {
//                         resultsContainer.classList.add("hidden");
//                     }
//                 })
//                 .catch(error => console.error("Error fetching search results:", error));
//         } else {
//             resultsContainer.classList.add("hidden");
//         }
//     });

//     document.addEventListener("click", function (e) {
//         if (!resultsContainer.contains(e.target) && e.target !== searchInput) {
//             resultsContainer.classList.add("hidden");
//         }
//     });
// });



document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("search-input");
    let resultsContainer = document.getElementById("search-results");
    let resultsList = document.getElementById("results-list");
    let debounceTimer;

    searchInput.addEventListener("keyup", function () {
        let query = this.value.trim();

        clearTimeout(debounceTimer); // Prevent unnecessary calls
        debounceTimer = setTimeout(() => {
            if (query.length > 1) {
                fetch(`/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsList.innerHTML = "";

                        if (data.length > 0) {
                            data.forEach(product => {
                                let listItem = document.createElement("li");
                                listItem.classList.add("p-2", "border-b", "hover:bg-gray-100", "cursor-pointer", "flex", "items-center");

                                listItem.innerHTML = `
                                    <img src="${product.primaryImage?.image_url || 'https://via.placeholder.com/100'}" 
                                        alt="${product.name}" 
                                        class="w-12 h-12 object-cover rounded-md mr-3">
                                    <div>
                                        <p class="text-gray-800 font-medium">${product.name}</p>
                                        <p class="text-gray-600 text-sm">₱${parseFloat(product.price).toFixed(2)}</p>
                                    </div>
                                `;

                                listItem.addEventListener("click", function () {
                                    window.location.href = `/product/${product.product_id}`;
                                });

                                resultsList.appendChild(listItem);
                            });

                            resultsContainer.classList.remove("hidden");
                        } else {
                            resultsList.innerHTML = `<li class="p-2 text-gray-500">No results found</li>`;
                            resultsContainer.classList.remove("hidden");
                        }
                    })
                    .catch(error => console.error("Error fetching search results:", error));
            } else {
                resultsContainer.classList.add("hidden");
            }
        }, 300); // Debounce for 300ms
    });

    document.addEventListener("click", function (e) {
        if (!resultsContainer.contains(e.target) && e.target !== searchInput) {
            resultsContainer.classList.add("hidden");
        }
    });
});
