<div class="bg-light mt-3 p-3 border rounded">
    <h4>How to retrieve your credentials</h4>
    <ol class="pl-3">
        <li>Go to your <a target="_blank" href="https://developers.facebook.com/">Facebook Developers apps page</a>
            and click on the name of your app otherwise create one using the <b>Create a New App</b> button
            and follow the instructions (make sure the test app switch is off).
        </li>
        <li>From the basic settings you will be able to access your API Key and API Secret.
            Also, click the Add Platform button below the settings configuration.
            Select Website in the platform dialog then enter the website URL.
        </li>
        <li>Once the app is set up, copy the App ID and App Secret into the fields below.</li>
        <li>Copy your <b>App ID</b> and <b>App Secret</b> into the fields below.</li>
        <li>In your facebook app’s dashboard, on the <b>Settings</b> tab set the <b>Valid OAuth redirect URIs</b>
            to <span
                style="color:green">{{ $formModel->getProvider('facebook')->makeEntryPointUrl('callback') }}</span>
        </li>
    </ol>
</div>
