# Google Drive Integration for Wordpress
A WordPress shortocde that shows shared Google Drive images.

## Installation
1. Download the latest release
2. Add your Google Service Account (generation tutorial [here](https://medium.com/@matheodaly.md/create-a-google-cloud-platform-account-in-3-steps-7e92d8298800)) key. Rename it to `google-credentials.json` and add the key into the downloaded plugin archive.
3. Install the final archive to your WP instance

## Usage
### Share your image with the service account
Choose an image from your Google Drive. Click on it and select Share > Share from the context menu.
Then share your image with the service account (client_email in your google service account key). Then click on **Copy link** to get the shareable link of your image.

### Embed in your post
So now you have a link to your image. To embed it use the following shortcode in your post/page:
```
[drive-img width="Optional" height="Optional"]The link to your image[/drive-img]
```
Where width and height the exact size of the image (which are optional, but recommended because the plugin displays the true resolution of the image).
