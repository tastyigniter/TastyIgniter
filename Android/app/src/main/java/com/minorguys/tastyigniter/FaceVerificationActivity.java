//
// Copyright (c) Microsoft. All rights reserved.
// Licensed under the MIT license.
//
// Microsoft Cognitive Services (formerly Project Oxford): https://www.microsoft.com/cognitive-services
//
// Microsoft Cognitive Services (formerly Project Oxford) GitHub:
// https://github.com/Microsoft/Cognitive-Face-Android
//
// Copyright (c) Microsoft Corporation
// All rights reserved.
//
// MIT License:
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:
//
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED ""AS IS"", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
//
package com.minorguys.tastyigniter;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.microsoft.projectoxford.face.FaceServiceClient;
import com.microsoft.projectoxford.face.FaceServiceRestClient;
import com.microsoft.projectoxford.face.contract.Face;
import com.microsoft.projectoxford.face.contract.VerifyResult;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.DecimalFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.UUID;

public class FaceVerificationActivity extends AppCompatActivity {
    // Background task for face verification.
    private static final String TAG = "MAMA";
    JSONArray jsonArray;
    JSONObject jsonObject;
    private class VerificationTask extends AsyncTask<Void, String, VerifyResult> {
        // The IDs of two face to verify.
        private UUID mFaceId0;
        private UUID mFaceId1;

        VerificationTask (UUID faceId0, UUID faceId1) {
            mFaceId0 = faceId0;
            mFaceId1 = faceId1;
        }

        @Override
        protected VerifyResult doInBackground(Void... params) {
            // Get an instance of face service client to detect faces in image.
            FaceServiceClient faceServiceClient = new FaceServiceRestClient(getString(R.string.endpoint), getString(R.string.subscription_key));
            try{
                publishProgress("Verifying...");

                // Start verification.
                return faceServiceClient.verify(
                        mFaceId0,      /* The first face ID to verify */
                        mFaceId1);     /* The second face ID to verify */
            }  catch (Exception e) {
                publishProgress(e.getMessage());
                addLog(e.getMessage());
                return null;
            }
        }

        @Override
        protected void onPreExecute() {
            // progressDialog.show();
            //addLog("Request: Verifying face " + mFaceId0 + " and face " + mFaceId1);
        }

        @Override
        protected void onProgressUpdate(String... progress) {
            progressDialog.setMessage(progress[0]);
            //setInfo(progress[0]);
        }

        @Override
        protected void onPostExecute(VerifyResult result) {

            if(result.isIdentical){
                if(progressDialog.isShowing())
                {
                    progressDialog.dismiss();
                }
                matchFound=true;

                Toast.makeText(FaceVerificationActivity.this, "MATCH FOUND", Toast.LENGTH_SHORT).show();
                new makeClearance().execute();
            }
            else{
                goOn(imageRunner+=1);
            }
        }
    }

    // Background task of face detection.
    private class DetectionTask extends AsyncTask<InputStream, String, Face[]> {
        // Index indicates detecting in which of the two images.
        private int mIndex;
        private boolean mSucceed = true;

        DetectionTask(int index) {
            mIndex = index;
        }

        @Override
        protected Face[] doInBackground(InputStream... params) {
            // Get an instance of face service client to detect faces in image.
            FaceServiceClient faceServiceClient = new FaceServiceRestClient(getString(R.string.endpoint), getString(R.string.subscription_key));
            try{

                publishProgress("Detecting...");
                Face[] manyfaces = faceServiceClient.detect(
                        params[0],  /* Input stream of image to detect */
                        true,       /* Whether to return face ID */
                        false,       /* Whether to return face landmarks */
                        /* Which face attributes to analyze, currently we support:
                           age,gender,headPose,smile,facialHair */
                        null);
                Log.d(TAG, "doInBackground: Occured");

                return manyfaces;
            }  catch (Exception e) {
                mSucceed = false;
                e.printStackTrace();
                publishProgress(e.getMessage());
                addLog(e.getMessage());
                return null;
            }
        }

        @Override
        protected void onPreExecute() {
            if(mIndex==0) {
                progressDialog.show();
            }
        }

        @Override
        protected void onProgressUpdate(String... progress) {
            if(mIndex==0) {
                progressDialog.setMessage(progress[0]);
                setInfo(progress[0]);
            }
        }

        @Override
        protected void onPostExecute(Face[] result) {
            Log.d(TAG, "onPostExecute: "+result.toString());
            // Show the result on screen when detection is done.
            setUiAfterDetection(result, mIndex, mSucceed);
        }
    }

    // Flag to indicate which task is to be performed.
    private static final int REQUEST_SELECT_IMAGE_0 = 0;
    private static final int REQUEST_SELECT_IMAGE_1 = 1;


    // The IDs of the two faces to be verified.
    private UUID mFaceId0;
    private UUID mFaceId1;

    // The two images from where we get the two faces to verify.
    private Bitmap mBitmap0;
    private Bitmap mBitmap1;

    // The adapter of the ListView which contains the detected faces from the two images.
    protected FaceListAdapter mFaceListAdapter0;
    protected FaceListAdapter mFaceListAdapter1;

    private boolean matchFound;
    private int imageRunner=0;
    private String currEmail;

    // Progress dialog popped up when communicating with server.
    ProgressDialog progressDialog;

    // When the activity is created, set all the member variables to initial state.
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_verification);

        // Initialize the two ListViews which contain the thumbnails of the detected faces.

        initializeFaceList(0);
        initializeFaceList(1);

        progressDialog = new ProgressDialog(this);
        progressDialog.setTitle(getString(R.string.progress_dialog_title));

        clearDetectedFaces(0);
        clearDetectedFaces(1);

        // Disable button "verify" as the two face IDs to verify are not ready.
        setVerifyButtonEnabledStatus(false);

        LogHelper.clearVerificationLog();
    }

    // Called when image selection is done. Begin detecting if the image is selected successfully.
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        // Index indicates which of the two images is selected.
        int index;
        if (requestCode == REQUEST_SELECT_IMAGE_0) {
            index = 0;
        } else if (requestCode == REQUEST_SELECT_IMAGE_1) {
            index = 1;
        } else {
            return;
        }

        if(resultCode == RESULT_OK) {
            // If image is selected successfully, set the image URI and bitmap.
            Bitmap bitmap = ImageHelper.loadSizeLimitedBitmapFromUri(
                    data.getData(), getContentResolver());
            if (bitmap != null) {
                // Image is select but not detected, disable verification button.
                setVerifyButtonEnabledStatus(false);
                clearDetectedFaces(index);

                // Set the image to detect.
                if (index == 0) {
                    mBitmap0 = bitmap;
                    mFaceId0 = null;
                } else {
                    mBitmap1 = bitmap;
                    mFaceId1 = null;
                }

                // Add verification log.
                addLog("Image" + index + ": " + data.getData() + " resized to " + bitmap.getWidth()
                        + "x" + bitmap.getHeight());

                // Start detecting in image.
                detect(bitmap, index);
            }
        }
    }

    // Clear the detected faces indicated by index.
    private void clearDetectedFaces(int index) {
        ListView faceList = (ListView) findViewById(
                index == 0 ? R.id.list_faces_0: R.id.list_faces_0);
        faceList.setVisibility(View.GONE);

        ImageView imageView =
                (ImageView) findViewById(index == 0 ? R.id.image_0: R.id.image_0);
        imageView.setImageResource(android.R.color.transparent);
    }

    // Called when the "Select Image0" button is clicked in face face verification.
    public void selectImage0(View view) {
        selectImage(0);
    }

    // Called when the "Select Image1" button is clicked in face face verification.
    public void selectImage1(View view) {
        selectImage(1);
    }

    // Called when the "Verify" button is clicked.
    public void verify(View view) {
        setAllButtonEnabledStatus(false);

        new getTheImagesFromServer().execute();

    }

    // View the log of service calls.
    public void viewLog(View view) {
        Intent intent = new Intent(this, VerificationLogActivity.class);
        startActivity(intent);
    }

    // Select the image indicated by index.
    private void selectImage(int index) {
        Intent intent = new Intent(this, SelectImageActivity.class);
        startActivityForResult(intent, index == 0 ? REQUEST_SELECT_IMAGE_0: REQUEST_SELECT_IMAGE_1 );
    }

    // Set the select image button is enabled or not.
    private void setSelectImageButtonEnabledStatus(boolean isEnabled, int index) {
        Button button;

        if (index == 0) {
            button = (Button) findViewById(R.id.select_image_0);
        } else{
            button = (Button) findViewById(R.id.select_image_0);
        }

        button.setEnabled(isEnabled);

        Button viewLog = (Button) findViewById(R.id.view_log);
        viewLog.setEnabled(isEnabled);
    }

    // Set the verify button is enabled or not.
    private void setVerifyButtonEnabledStatus(boolean isEnabled) {
        Button button = (Button) findViewById(R.id.verify);
        button.setEnabled(isEnabled);
    }

    // Set all the buttons are enabled or not.
    private void setAllButtonEnabledStatus(boolean isEnabled) {
        Button selectImage0 = (Button) findViewById(R.id.select_image_0);
        selectImage0.setEnabled(isEnabled);

        Button selectImage1 = (Button) findViewById(R.id.select_image_0);
        selectImage1.setEnabled(isEnabled);

        Button verify = (Button) findViewById(R.id.verify);
        verify.setEnabled(isEnabled);

        Button viewLog = (Button) findViewById(R.id.view_log);
        viewLog.setEnabled(isEnabled);
    }

    // Initialize the ListView which contains the thumbnails of the detected faces.
    private void initializeFaceList(final int index) {
        ListView listView =
                (ListView) findViewById(index == 0 ? R.id.list_faces_0: R.id.list_faces_0);

        // When a detected face in the GridView is clicked, the face is selected to verify.
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                FaceListAdapter faceListAdapter =
                        index == 0 ? mFaceListAdapter0: mFaceListAdapter1;

                if (!faceListAdapter.faces.get(position).faceId.equals(
                        index == 0 ? mFaceId0: mFaceId1)) {
                    if (index == 0) {
                        mFaceId0 = faceListAdapter.faces.get(position).faceId;
                    } else {
                        mFaceId1 = faceListAdapter.faces.get(position).faceId;
                    }

                    ImageView imageView =
                            (ImageView) findViewById(index == 0 ? R.id.image_0: R.id.image_0);
                    imageView.setImageBitmap(faceListAdapter.faceThumbnails.get(position));

                    setInfo("");
                }

                // Show the list of detected face thumbnails.
                ListView listView = (ListView) findViewById(
                        index == 0 ? R.id.list_faces_0: R.id.list_faces_0);
                listView.setAdapter(faceListAdapter);
            }
        });
    }

    // Show the result on screen when verification is done.
    private void setUiAfterVerification(VerifyResult result) {
        // Verification is done, hide the progress dialog.
        progressDialog.dismiss();

        // Enable all the buttons.
        setAllButtonEnabledStatus(true);

        // Show verification result.
        if (result != null) {
            DecimalFormat formatter = new DecimalFormat("#0.00");
            String verificationResult = (result.isIdentical ? "The same person": "Different persons");
            if(result.isIdentical)
            {
                Toast.makeText(this, "Identification Completed , Logging You IN", Toast.LENGTH_SHORT).show();

            }
        }
    }

    // Show the result on screen when detection in image that indicated by index is done.
    private void setUiAfterDetection(Face[] result, int index, boolean succeed) {
        setSelectImageButtonEnabledStatus(true, index);

        if (succeed) {
            addLog("Response: Success. Detected "
                    + result.length + " face(s) in image" + index);

            setInfo(result.length + " face" + (result.length != 1 ? "s": "")  + " detected");

            // Show the detailed list of detected faces.
            FaceListAdapter faceListAdapter = new FaceListAdapter(result, index);

            // Set the default face ID to the ID of first face, if one or more faces are detected.
            if (faceListAdapter.faces.size() != 0) {
                if (index == 0) {
                    mFaceId0 = faceListAdapter.faces.get(0).faceId;
                }
                else {
                    mFaceId1 = faceListAdapter.faces.get(0).faceId;
                }
                // Show the thumbnail of the default face.
                if(index==0){
                    ImageView imageView = (ImageView) findViewById(index == 0 ? R.id.image_0: R.id.image_0);
                    imageView.setImageBitmap(faceListAdapter.faceThumbnails.get(0));
                }


            }

            // Show the list of detected face thumbnails.
            if (index==0)
            {
                ListView listView = (ListView) findViewById(
                        index == 0 ? R.id.list_faces_0: R.id.list_faces_0);
                listView.setAdapter(faceListAdapter);
                listView.setVisibility(View.VISIBLE);

            }

            // Set the face list adapters and bitmaps.
            if (index == 0) {
                mFaceListAdapter0 = faceListAdapter;
                mBitmap0 = null;
            } else {
                mFaceListAdapter1 = faceListAdapter;
                mBitmap1 = null;
            }
        }

        if (result != null && result.length == 0) {
            setInfo("No face detected!");
        }

        if ((index == 0 && mBitmap1 == null) || (index == 1 && mBitmap0 == null) || index == 2) {
            progressDialog.dismiss();
        }

        if (mFaceId0 != null) {
            setVerifyButtonEnabledStatus(true);
        }
    }

    // Start detecting in image specified by index.
    private void detect(Bitmap bitmap, int index) {
        // Put the image into an input stream for detection.
        ByteArrayOutputStream output = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG, 100, output);
        ByteArrayInputStream inputStream = new ByteArrayInputStream(output.toByteArray());
        Log.d(TAG, output.toString());

        // Start a background task to detect faces in the image.
        new DetectionTask(index).execute(inputStream);

        setSelectImageButtonEnabledStatus(false, index);

        // Set the status to show that detection starts.
        setInfo("Detecting...");
    }

    // Set the information panel on screen.
    private void setInfo(String info) {
        TextView textView = (TextView) findViewById(R.id.info);
        textView.setText(info);
    }

    // Add a log item.
    private void addLog(String log) {
        LogHelper.addVerificationLog(log);
    }

    // The adapter of the GridView which contains the thumbnails of the detected faces.
    private class FaceListAdapter extends BaseAdapter {
        // The detected faces.
        List<Face> faces;

        int mIndex;

        // The thumbnails of detected faces.
        List<Bitmap> faceThumbnails;

        // Initialize with detection result and index indicating on which image the result is got.
        FaceListAdapter(Face[] detectionResult, int index) {
            faces = new ArrayList<>();
            faceThumbnails = new ArrayList<>();
            mIndex = index;

            if (detectionResult != null) {
                faces = Arrays.asList(detectionResult);
                for (Face face: faces) {
                    try {
                        // Crop face thumbnail without landmarks drawn.
                        faceThumbnails.add(ImageHelper.generateFaceThumbnail(
                                index == 0 ? mBitmap0: mBitmap1, face.faceRectangle));
                    } catch (IOException e) {
                        // Show the exception when generating face thumbnail fails.
                        setInfo(e.getMessage());
                    }
                }
            }
        }

        @Override
        public int getCount() {
            return faces.size();
        }

        @Override
        public Object getItem(int position) {
            return faces.get(position);
        }

        @Override
        public long getItemId(int position) {
            return position;
        }

        @Override
        public View getView(final int position, View convertView, ViewGroup parent) {
            if (convertView == null) {
                LayoutInflater layoutInflater =
                        (LayoutInflater)getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                convertView = layoutInflater.inflate(R.layout.item_face, parent, false);
            }
            convertView.setId(position);

            Bitmap thumbnailToShow = faceThumbnails.get(position);
            if (mIndex == 0 && faces.get(position).faceId.equals(mFaceId0)) {
                thumbnailToShow = ImageHelper.highlightSelectedFaceThumbnail(thumbnailToShow);
            } else if (mIndex == 1 && faces.get(position).faceId.equals(mFaceId1)){
                thumbnailToShow = ImageHelper.highlightSelectedFaceThumbnail(thumbnailToShow);
            }

            ((ImageView)convertView.findViewById(R.id.image_face)).setImageBitmap(thumbnailToShow);

            return convertView;
        }
    }
    private class getTheImagesFromServer extends AsyncTask<Void,Void,Void>{

        public getTheImagesFromServer() {
        }

        @Override
        protected Void doInBackground(Void... voids) {
            String url = "http://u1701227.nettech.firm.in/api/image.php";
            StringRequest request=new StringRequest(url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response)
                {
                    try
                    {
                        if(response!=null)
                        {
                            Log.d(TAG, "onResponse is Not Null: ");
                            jsonArray = new JSONArray(response);
                            Log.d(TAG, "So JSOn is: "+jsonArray);
                            publishProgress();
                        }
                        else
                        {
                            Log.d(TAG, "onResponse is NULL: ");
                        }
                    }
                    catch (Exception e)
                    {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {

                }
            });
            RequestQueue rq= Volley.newRequestQueue(getApplicationContext());
            rq.add(request);

            return null;
        }

        @Override
        protected void onProgressUpdate(Void... values) {
            super.onProgressUpdate(values);
            goOn(imageRunner);

        }
    }
    private class downloadAndVerify extends AsyncTask<String,Bitmap,Bitmap>{
        downloadAndVerify(){

        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog.setMessage("Verifying...");
            progressDialog.show();
        }

        @Override
        protected void onProgressUpdate(Bitmap... values) {
            super.onProgressUpdate(values);
            ((ImageView)findViewById(R.id.imageView2)).setImageBitmap(values[0]);

        }

        @Override
        protected void onPostExecute(Bitmap bitmap) {
            super.onPostExecute(bitmap);
            new VerificationTask(mFaceId0,mFaceId1).execute();
            Log.d(TAG, "Verification Task Started with: "+mFaceId0+" "+mFaceId1);

            if(progressDialog.isShowing()){
                progressDialog.setMessage("Matching Process Started...");
            }


        }

        @Override
        protected Bitmap doInBackground(String... strings) {
            try{
                URL url = new URL(strings[0]);
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setDoInput(true);
                connection.connect();


                Bitmap bitmap= BitmapFactory.decodeStream(connection.getInputStream());
                publishProgress(bitmap);


                ByteArrayOutputStream output = new ByteArrayOutputStream();
                bitmap.compress(Bitmap.CompressFormat.JPEG, 100, output);
                String b64 = Base64.encodeToString(output.toByteArray(),Base64.DEFAULT);
                Log.d(TAG, "doInBackground Image is Downloaded: "+b64.length());
                return bitmap;
            }
            catch(Exception e){
                e.printStackTrace();
                return null;
            }
        }
    }
    private void goOn(int index){
        if(index>=jsonArray.length()){
            finish();
        }

        try{
            Log.d(TAG, "JSONARRAY: "+jsonArray);
            jsonObject = jsonArray.getJSONObject(index);
            String meriImageURL = jsonObject.getString("image");
            currEmail = jsonObject.getString("email");

            try{
                if(jsonObject.getString("uuid")==null){}
                mFaceId1 =  UUID.fromString(jsonObject.getString("uuid"));
                StringBuilder sB = new StringBuilder(meriImageURL);
                sB.deleteCharAt(1);
                sB.deleteCharAt(1);
                sB.deleteCharAt(0);
                meriImageURL="http://u1701227.nettech.firm.in/"+ sB.toString();
                new downloadAndVerify().execute(meriImageURL);
            }
            catch(Exception e)
            {
                goOn(imageRunner+=1);
            }

            Log.d(TAG, "Checking Nullness: "+mFaceId1);



        }
        catch(Exception e){
            e.printStackTrace();
        }
    }

    private class makeClearance extends AsyncTask<Void,Void,Void>{

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            progressDialog.setMessage("Logging You In.....!!");
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            super.onPostExecute(aVoid);
            progressDialog.dismiss();
            Intent i =new Intent();
            setResult(RESULT_OK,i);
            finish();

        }

        @Override
        protected void onProgressUpdate(Void... values) {
            super.onProgressUpdate(values);
        }

        @Override
        protected Void doInBackground(Void... voids) {
            Log.d(TAG, "MakeClearance Function Called ");
            String url = "http://u1701227.nettech.firm.in/api/login_email.php?email="+currEmail;
            StringRequest request=new StringRequest(url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response)
                {
                    try
                    {
                        if(response!=null)
                        {
                            Log.d(TAG, "Got the Response??: "+response);
                            JSONObject jsonObject = new JSONObject(response);
                            UserData o =new UserData();
                            o.setstatus(true);
                            o.setEmail(currEmail);
                            o.setFname(jsonObject.get("fname").toString());
                            o.setLname(jsonObject.get("lname").toString());
                            o.setMobile(jsonObject.get("mobile").toString());
                            o.setAddress1(jsonObject.get("address1").toString());
                            o.setAddress2(jsonObject.get("address2").toString());

                            o.setState(jsonObject.get("state").toString());
                            o.setCity(jsonObject.get("city").toString());
                            o.setPin(jsonObject.get("pin").toString());
                            o.setCountry(jsonObject.get("country_name").toString());

                            o.setId(jsonObject.getString("cust_id"));
                            Log.d(TAG, "GET Fname: "+o.getFname());
                        }

                    }
                    catch (Exception e)
                    {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {

                }
            });
            RequestQueue rq= Volley.newRequestQueue(getApplicationContext());
            rq.add(request);
            return null;
        }
    }

}

