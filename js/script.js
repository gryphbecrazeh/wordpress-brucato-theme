const semiPresentNavBar = () => {
	const header = document.querySelector("header");
	let prevScrollPos = 0;

	document.addEventListener("scroll", () => {
		let { classList } = header;
		let currentPosition = window.scrollY;
		if (currentPosition < prevScrollPos || currentPosition === 0)
			header.classList.remove("hidden");
		if (currentPosition > prevScrollPos && !classList.contains("hidden"))
			header.classList.add("hidden");
		return (prevScrollPos = currentPosition);
	});
};

let customSlidingText = intervalLength => {
	let titles = [...document.querySelectorAll(".customSlidingText h1")];
	if (titles.length >= 1) {
		//   Index of slide
		let index = 0;
		//     Slide function, uses css animation
		let slide = item => {
			item.style.display = "block";
			item.style.animationDuration = `${intervalLength}ms`;
			item.style.animationName = "slide";

			// Hide frame
			setTimeout(() => (item.style.display = "none"), intervalLength);
		};
		let interval = setInterval(() => {
			let text = titles[index++];
			if (text) {
				slide(text);
			} else {
				index = 0;
				text = titles[index++];
				slide(text);
			}
		}, intervalLength);
		slide(titles[index++]);
	}
};
let initializeSplitscreenFeaturedProjects = () => {
	let wrapper = document.querySelector("#split-screen-wrapper");
	if (wrapper) {
		let layers = [...wrapper.querySelectorAll(".layer")];
		let topLayer = wrapper.querySelector(".skewed .top");
		let forms = [...wrapper.querySelectorAll("form")];

		layers.forEach((layer, index) => {
			// Identify which of the layers to manipulate
			let next = index > 0 ? 0 : 1;

			let contentBody = layers[next].querySelector(".content-body");
			let heading = layer.querySelector(".heading");
			let content = layer.querySelector(".content");
			// let layerForm = layer.querySelector("form");
			// let title = layer.querySelector(".title");
			// let underline = title.querySelector(".underline");

			layer.addEventListener("mouseenter", e => {
				let top = [...e.target.classList].includes("top");
				// underline.style.width = "100%";
				// Make the opposite side's opacity 0
				contentBody.style.opacity = 0;
				// layerForm.style.opacity = 1;
				if (top) {
					// If the item selected is the top layer grow it
					return (topLayer.style.width = "85vw");
				}
				// If the item selected is not the top layer shrink it

				return (topLayer.style.width = "15vw ");
			});

			layer.addEventListener("mouseleave", () => {
				// underline.style.width = "0";
				topLayer.style.width = "50vw";

				//     Set all layers' content-body to 100% opacity as a cover all solution to the mouse leaving
				layers.forEach(() => {
					contentBody.style.opacity = 1;
				});
				// forms.forEach((form) => {
				// 	form.style.opacity = 0;
				// });
			});
		});
	}
};
// Interval to highlight the featured technologies on the homepage
let techHighlighter = (
	delay = 1000,
	containerIdentifier = ".tech-container"
) => {
	let container = document.querySelector(containerIdentifier);
	if (container) {
		// Hilight Links
		let hilight = item => {
			item.classList.add("hilight");
			setTimeout(() => item.classList.remove("hilight"), delay);
		};
		let techNodeArray = [...container.querySelectorAll(".tech")];

		if (techNodeArray.length > 1) {
			let index = 0;
			let maxIndex = techNodeArray.length;
			let interval = setInterval(() => {
				if (index >= maxIndex) {
					index = 0;
				}
				return hilight(techNodeArray[`${index++}`]);
			}, delay);
		}
	}
};
// Highlight half of the text in the heading by modifying the innerHTML
let styleHeadingTags = () => {
	// Hilight text
	let htags = [
		...document.querySelectorAll("h1"),
		...document.querySelectorAll("h2"),
		...document.querySelectorAll("h3"),
		...document.querySelectorAll("h4"),
		...document.querySelectorAll("h5"),
		...document.querySelectorAll("h6")
	];

	if (htags.length >= 1) {
		htags.forEach(item => {
			let words = [...item.innerText.match(/\w+/gim)];
			let res = words.map((word, index) => {
				if (index >= words.length / 2) {
					return `<span class='heading-hilight'>${word}</span>`;
				}
				return word;
			});
			item.innerHTML = res.join(" ");
		});
	}
};
let mouseHoverElement = (dims = 80, containerIdentifier = "body") => {
	let mouseHoverElement = document.createElement("div");
	// currently isn't limited because it is position fixed, and the e.y and e.x only goes by the window position
	let container = document.querySelector(containerIdentifier);
	mouseHoverElement.id = "mouseHoverElement";
	mouseHoverElement.style.width = `${dims}px`;
	mouseHoverElement.style.height = `${dims}px`;
	container.appendChild(mouseHoverElement);
	let placeBox = e => {
		let center = dims / 2;
		mouseHoverElement.style.top = `${e.y - center}px`;
		mouseHoverElement.style.left = `${e.x - center}px`;
	};
	document.addEventListener("mousemove", e => placeBox(e));
};
// Scrolls github repo container
const idleScroller = (
	pace = 2000,
	containerIdentifier = ".scroll-container",
	pixelInterval = 10
) => {
	let container = document.querySelector(containerIdentifier);
	if (container) {
		let maxHeight = container.scrollTopMax;
		let avgScrollDistance = maxHeight / pixelInterval;
		let scrollIntervalPace = pace;
		let scrollInterval, scrollTimeout;

		let scroller = () => {
			let { scrollTop } = container;
			let scrollDistance =
				scrollTop + avgScrollDistance <= maxHeight
					? scrollTop + avgScrollDistance
					: 0;
			return container.scroll({
				top: scrollDistance,
				behavior: "smooth"
			});
		};

		let assignScrollInterval = () => {
			scrollInterval = setInterval(scroller, scrollIntervalPace);
		};

		container.addEventListener("scroll", () => {
			clearTimeout(scrollTimeout);
			clearInterval(scrollInterval);
			scrollTimeout = setTimeout(assignScrollInterval, scrollIntervalPace);
		});
		assignScrollInterval();
	}
};
let handleMainNavigation = () => {
	let button = document.querySelector(".nav-button");
	if (button) {
		button.addEventListener("click", () => {
			let navigation = document.querySelector(".brucato-navigation");
			let closed =
				[...navigation.classList].indexOf("closed") === -1 ? false : true;
			if (closed) {
				button.classList.add("open");
				return navigation.classList.remove("closed");
			} else {
				button.classList.remove("open");
				return navigation.classList.add("closed");
			}
		});
	}
};

let handleHamburgerNavigation = () => {
	let navButton = document.querySelector(".brucato-nav-button");
	let sidebar = document.querySelector(".brucato-sidebar");
	if (navButton && sidebar) {
		let closeSidebar = () => {
			sidebar.classList.remove("open");
		};
		document.addEventListener("click", e => {
			if (e.target != navButton) {
				let sidebarOpened =
					[...sidebar.classList].indexOf("open") > -1 ? true : false;
				if (sidebarOpened) {
					closeSidebar();
				}
			}
		});
		navButton.addEventListener("click", () => {
			let sidebarOpened =
				[...sidebar.classList].indexOf("open") > -1 ? true : false;
			if (sidebarOpened) {
				closeSidebar();
			} else {
				sidebar.classList.add("open");
			}
		});
	}
};
let handleLinkStyles = () => {
	let container = document.querySelector(".brucato-category-list");
	let links = [...container.querySelectorAll("a")];
	if (links.length > 0) {
		links.forEach(link => {
			let target = link.getAttribute("href");
			if (target && target == window.location.href) {
				link.classList.add("current");
			}
		});
	}
};

let handleCarousel = () => {
	const carousels = [...document.querySelectorAll(".carousel-container")];

	carousels.forEach(carousel => {
		let slides = [...carousel.querySelectorAll(".slide")];
		if (slides.length >= 1) {
			const center = Math.floor(slides.length / 2);
			const cap = slides.length - 1;
			// Initialize the center
			slides[center].classList.add("center");

			let slideLeft = slides => {
				slides[0].classList.add("transition");
				slides[center].classList.remove("center");
				carousel.removeChild(slides[0]);
				slides[0].classList.remove("transition");
				carousel.appendChild(slides[0]);
				slides = [...carousel.querySelectorAll(".slide")];
				slides[center].classList.add("center");
				addClickEvent(slides);
			};
			let slideRight = slides => {
				slides[cap].classList.add("transition");
				slides[center].classList.remove("center");
				carousel.removeChild(slides[cap]);
				slides[cap].classList.remove("transition");
				carousel.prepend(slides[cap]);
				slides = [...carousel.querySelectorAll(".slide")];
				slides[center].classList.add("center");
				addClickEvent(slides);
			};

			// add onClick
			let addClickEvent = slides => {
				//   Slide Left
				for (let i = 0; i < center; i++) {
					slides[i].addEventListener(
						"click",
						() => (slides = slideRight(slides))
					);
				}
				//   Slide Right
				for (let i = center + 1; i <= cap; i++) {
					slides[i].addEventListener(
						"click",
						() => (slides = slideLeft(slides))
					);
				}
			};
			addClickEvent(slides);
		}
	});
};

let handleCollage = () => {
	let container = document.querySelector(".brucato-cascading-container");
	if (container) {
		var directions = ["top", "bottom", "left", "right"];

		let shadowbox = container.querySelector("#brucato-shadowbox-display");
		let shadowboxImage = document.createElement("img");
		shadowboxImage.classList.add("shadowbox-image");

		let tiles = [...container.querySelectorAll(".tile")];
		let images = [...container.querySelectorAll("img")];

		let getRandomPosition = () => {
			return Math.floor(Math.random() * Math.floor(directions.length));
		};

		let closeShadowbox = () => {
			shadowbox.removeChild(shadowboxImage);
			shadowbox.classList.remove("open");
		};
		let openShadowbox = e => {
			let image = e.target.getAttribute("src");
			let shadowboxOpened =
				[...shadowbox.classList].indexOf("open") > -1 ? true : false;
			if (image && !shadowboxOpened) {
				shadowboxImage.setAttribute("src", image);
				shadowbox.appendChild(shadowboxImage);
				shadowbox.classList.add("open");
				shadowbox.addEventListener("click", closeShadowbox);
			}
		};
		tiles.forEach(tile => {
			tile.classList.add(directions[getRandomPosition()]);
			tile.classList.add(directions[getRandomPosition()]);
		});

		images.forEach(image => {
			image.addEventListener("click", openShadowbox);
		});
	}
};

// Execute Scripts
document.addEventListener("DOMContentLoaded", () => {
	// if (window.innerWidth > 800) {
	// mouseHoverElement(80, "#introduction");
	// idleScroller(1200, ".gh_repos_list", 2);
	// }
	handleMainNavigation();
	handleHamburgerNavigation();
	handleLinkStyles();
	handleCarousel();
	handleCollage();

	// styleHeadingTags();
	// customSlidingText(3000);
	// techHighlighter(1000);
	// initializeSplitscreenFeaturedProjects();
	// semiPresentNavBar();
});
