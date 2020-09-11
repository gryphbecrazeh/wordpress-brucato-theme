window.addEventListener("DOMContentLoaded", () => {
	let wrappers = [...document.querySelectorAll(".metabox-wrapper")];
	// Reuse code
	wrappers.forEach(wrapper => {
		let addButton = wrapper.querySelector("input#image-upload-button");
		let deleteButton = wrapper.querySelector("input#image-delete-button");
		let hidden = wrapper.querySelector("input#image-hidden-field");

		let renderImages = array => {
			array.forEach(item => {
				let attachment = item.toJSON();
				let image = document.createElement("img");
				image.setAttribute("src", attachment.url);
				image.setAttribute("style", "width:100%; height:auto; max-width:15em;");
				// image.onclick = () => wrapper.removeChild(image);
				wrapper.appendChild(image);
			});
		};

		let removeImage = image => {
			wrapper.removeChild(image);
			let newImages = [...wrapper.querySelectorAll("img")];
		};

		let getImageData = customUploads => {
			if (customUploads) {
				let { imageData } = customUploads;
				if (imageData) {
					imageData.forEach(item => {
						let image = document.createElement("img");
						image.setAttribute("src", item.src);
						image.setAttribute(
							"style",
							"width:100%; height:auto; max-width:15em;"
						);
						wrapper.appendChild(image);
					});
					hidden.setAttribute(
						"value",
						JSON.stringify([
							...imageData.map(attachment => {
								return {
									id: attachment.id,
									url: attachment.src
								};
							})
						])
					);
				}
			}
		};
		// Carousel
		if (customUploads1 && wrapper.getAttribute("name") == "carousel_1") {
			getImageData(customUploads1);
		}
		if (customUploads2 && wrapper.getAttribute("name") == "carousel_2") {
			getImageData(customUploads2);
		}
		if (customUploads3 && wrapper.getAttribute("name") == "carousel_3") {
			getImageData(customUploads3);
		}
		// Collage
		if (customUploads4 && wrapper.getAttribute("name") == "collage_1") {
			getImageData(customUploads4);
		}

		let customUploader = wp.media({
			title: "Select an image",
			button: {
				text: "Use this Image"
			},
			multiple: true
		});

		addButton.addEventListener("click", () => {
			if (customUploader) {
				customUploader.open();
			}
		});
		customUploader.on("select", () => {
			// let attachment = customUploader.state().get("selection").first().toJSON();
			// img.setAttribute("src", attachment.url);
			// img.setAttribute("style", "width:100%; height:auto; max-width:15em;");
			// hidden.setAttribute(
			// 	"value",
			// 	JSON.stringify([{ id: attachment.id, url: attachment.url }])
			// );
			let attachments = [...customUploader.state().get("selection")];

			renderImages(attachments);

			hidden.setAttribute(
				"value",
				JSON.stringify([
					...attachments.map(attachment => {
						return {
							id: attachment.id,
							url: attachment.attributes.url
						};
					})
				])
			);
		});
		deleteButton.addEventListener("click", () => {
			let images = [...wrapper.querySelectorAll("img")];
			images.forEach(img => {
				wrapper.removeChild(img);
			});
			hidden.removeAttribute("value");
		});
	});
	// End DOM Content Loaded
});
