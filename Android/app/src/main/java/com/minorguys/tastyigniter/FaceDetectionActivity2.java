package com.minorguys.tastyigniter;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.Toast;

import com.microsoft.projectoxford.face.FaceServiceClient;
import com.microsoft.projectoxford.face.FaceServiceRestClient;
import com.microsoft.projectoxford.face.contract.Face;

import java.io.ByteArrayInputStream;
import java.io.ByteArrayOutputStream;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.UUID;

public class FaceDetectionActivity2 extends AppCompatActivity {

    private static final int GET_THE_IMAGE=344;

    private UUID sFaceID;
    private Bitmap sBitmap;
    private FaceListAdapter sFaceListAdapter;
    ProgressDialog progressDialog;

    public static final String TAG = "MAMA";



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        Log.d(TAG, "onCreate: "+"OnCreate has been called");
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_face_detection2);

    }


    public void selectImage(View view){
        Intent i = new Intent(this,SelectImageActivity.class);
        startActivityForResult(i,GET_THE_IMAGE);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if(requestCode==GET_THE_IMAGE && resultCode==RESULT_OK){
            try{

                Bitmap bitmap = ImageHelper.loadSizeLimitedBitmapFromUri(data.getData(),getContentResolver());
                //  Bitmap bitmap2 = BitmapFactory.decodeFile()
                sBitmap = bitmap;

                ByteArrayOutputStream output = new ByteArrayOutputStream();
                bitmap.compress(Bitmap.CompressFormat.JPEG, 100, output);
                ByteArrayInputStream inputStream = new ByteArrayInputStream(output.toByteArray());
                new DetectionTask().execute(inputStream);
            }
            catch (Exception e){
                Log.e(TAG, "Exception in Bitmap "+e.getMessage() );
            }
        }

    }
    private class DetectionTask extends AsyncTask<InputStream,String,Face[]>{
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            //progressDialog.show();
            //progressDialog.setMessage("Detecting Image With the Server!");
        }

        @Override
        protected void onPostExecute(Face[] faces) {
            super.onPostExecute(faces);
            //progressDialog.cancel();
            setUIAfterDetection(faces);
        }

        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
        }

        @Override
        protected Face[] doInBackground(InputStream... inputStreams) {

            Log.d(TAG, "In doInBackground with InputSteam: "+inputStreams[0]);
                FaceServiceClient faceServiceClient = new FaceServiceRestClient(getString(R.string.endpoint), getString(R.string.subscription_key));
                try{
                    return faceServiceClient.detect(inputStreams[0],true,false,null);
                }  catch (Exception e) {
                    publishProgress(e.getMessage());
                    return null;
                }
        }
    }
    private void setUIAfterDetection(Face[] faces){


        sFaceListAdapter = new FaceListAdapter(faces);



        if(faces.length!=0)
        {
            Toast.makeText(this, "Faces Detected!", Toast.LENGTH_SHORT).show();
            Log.d(TAG, "Faces Detected! : ");
        }
        else{
            Toast.makeText(this, "No Faces Could Be Detected!", Toast.LENGTH_SHORT).show();
            Log.d(TAG, "No Faces Could Be Detected! : ");

        }

        if(sFaceListAdapter.faces.size()!=0) {
            sFaceID = sFaceListAdapter.faces.get(0).faceId;

            ImageView imageView = (ImageView) findViewById(R.id.displayImage);
            imageView.setImageBitmap(sFaceListAdapter.faceThumbnails.get(0));
            Log.d(TAG, "setUIAfterDetection Checking FaceAdapter: " + sFaceListAdapter.getCount());
            sBitmap = sFaceListAdapter.faceThumbnails.get(0);
        }


    }
    public class FaceListAdapter extends BaseAdapter {

        List<Face> faces;
        List<Bitmap> faceThumbnails;

        FaceListAdapter(Face[] resultFaces){
            Log.d(TAG, "FaceListAdapter: "+"Face Adapter has been created");
            faces=new ArrayList<>();
            faceThumbnails=new ArrayList<>();

            if(resultFaces!=null){
                faces= Arrays.asList(resultFaces);
                for(Face face : faces){
                    try{
                        faceThumbnails.add(ImageHelper.generateFaceThumbnail(sBitmap,face.faceRectangle));
                    }
                    catch (Exception e){
                        e.printStackTrace();
                    }
                }
            }


        }


        @Override
        public int getCount() {
            return faces.size();
        }

        @Override
        public Object getItem(int i) {
            return faces.get(i);
        }

        @Override
        public long getItemId(int i) {
            return i;
        }

        @Override
        public View getView(int i, View view, ViewGroup viewGroup) {
            if (view == null) {
                LayoutInflater layoutInflater = (LayoutInflater)getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                view = layoutInflater.inflate(R.layout.item_face,viewGroup);
            }
            view.setId(i);

            Bitmap thumbnailToShow = faceThumbnails.get(i);
            if(faces.get(i).faceId.equals(sFaceID)){
                thumbnailToShow = ImageHelper.highlightSelectedFaceThumbnail(thumbnailToShow);
            }
            ((ImageView)view.findViewById(R.id.image_face)).setImageBitmap(thumbnailToShow);

            return view;
        }
    }
    public void proceed(View view){
        ByteArrayOutputStream output = new ByteArrayOutputStream();
        sBitmap.compress(Bitmap.CompressFormat.JPEG, 50, output);
        String b64 = Base64.encodeToString(output.toByteArray(),Base64.DEFAULT);
        Intent i =new Intent();
        i.putExtra("ProfilePhoto",b64);
        i.putExtra("UUIDPhoto",sFaceID);
        Log.d(TAG, "FACEID to be sent to other Activity: "+sFaceID);
        setResult(RESULT_OK,i);
        finish();
    }
}


