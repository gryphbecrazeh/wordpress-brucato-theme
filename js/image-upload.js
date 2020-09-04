window.addEventListener("DOMContentLoaded", () => {
	let addButton = document.getElementById("image-upload-button");
	let deleteButton = document.querySelector("#image-delete-button");
	let hidden = document.querySelector("#image-hidden-field");
	let wrapper = document.querySelector(".image-wrapper");

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

	if (customUploads) {
		let { imageData } = customUploads;
		let image = imageData;
		if (image) {
			console.log(image);
			let img = document.createElement("img");
			img.setAttribute("src", image.src);
			img.setAttribute("style", "width:100%; height:auto; max-width:15em;");
			hidden.setAttribute(
				"value",
				JSON.stringify([{ id: image.id, url: image.src }])
			);
		}
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
						url: attachment.url
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
	// End DOM Content Loaded
});
