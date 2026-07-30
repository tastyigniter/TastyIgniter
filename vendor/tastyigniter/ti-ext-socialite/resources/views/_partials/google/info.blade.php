<div class="bg-light mt-3 p-3 border rounded">
    <h4>How to retrieve your credentials</h4>
    <ol class="pl-3">
        <li>Go to <a target="_blank" href="https://console.developers.google.com/project">Google Developers Console</a>
            and select your project, otherwise create one using <b>Create Project</b>and follow the instructions.
            Name it something like <b>TastyIgniter Social Login</b>
        </li>
        <li>Once the project is created, goto <b>API Manager</b> from the navigation bar and
            click <b>Enable API</b>. Search for the Google+ API and add it.
        </li>
        <li>
            In the side menu select the <b>Credentials</b> and click on <b>Create Credentials > OAuth Client ID</b>.
            Choose the type as <b>Web Application</b>. Set the <b>Authorized redirect URIs</b> to
            <span style="color:green">{{ $formModel->getProvider('google')->makeEntryPointUrl('callback') }}</span>
            and click create. It will show you the Client ID and Client Secret which should be copied into the fields
            below.
        </li>
    </ol>
</div>
