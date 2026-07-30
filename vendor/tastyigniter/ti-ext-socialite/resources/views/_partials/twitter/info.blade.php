<div class="bg-light mt-3 p-3 border rounded">
    <h4>How to retrieve your credentials</h4>
    <ol class="pl-3">
        <li>Go to <a target="_blank" href="https://apps.twitter.com/">https://apps.twitter.com/</a> and create a new
            app.
        </li>
        <li>
            Set <b>Website</b> to <span style="color:green">{{ url()->to('') }}</span> and <b>Callback URL</b> to
            <span
                style="color:green">{{ $formModel->getProvider('twitter')->makeEntryPointUrl('callback') }}</span>
        </li>
        <li>Click <b>Create your Twitter Application</b>.</li>
        <li>Copy your <b>API Key</b> and <b>API Secret</b> from the <b>API Keys</b> tab and paste them below.</li>
    </ol>
</div>
