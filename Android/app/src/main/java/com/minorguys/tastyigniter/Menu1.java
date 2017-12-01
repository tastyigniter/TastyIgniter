package com.minorguys.tastyigniter;


import android.content.ComponentName;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.os.Environment;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.content.IntentCompat;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileOutputStream;
import java.io.FileReader;

/**
 * Created by hp-u on 17-09-2017.
 */

public class Menu1 extends Fragment
{

    String url="http://u1701227.nettech.firm.in/api/category.php";
    String imgcategory="http://u1701227.nettech.firm.in/TastyIgniter-master/assets/images/";
    TextView tv1,tv2,tv3,tv4,tv5,tv6,tv7,tv8;
    ImageView iv1,iv2,iv3,iv4;
    String t1,t2,t3,t4;
    String a[]=new String[4];
    int i=0;
    String lang="?lang=";
    File langFile;
    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState)
    {   langFile =new File(getContext().getFilesDir(),"langFile.txt");




     try {
         String S1=GetCacheDirExample.readAllCachedText(getContext(), "myCacheFile.txt");                                                            ;
         String S=S1.substring(0,2);
         if (!(S.equals("en") || S.equals("fr"))) {

             AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
             boolean a=S.equalsIgnoreCase("en");
            // Toast.makeText(getActivity(),S+""+a, Toast.LENGTH_SHORT).show();
             builder.setTitle("Language");
             builder.setMessage("Choose your Language");


             builder.setPositiveButton("English", new DialogInterface.OnClickListener() {

                 public void onClick(DialogInterface dialog, int which) {

                     // Do nothing, but close the dialog
                     // String textToCache = "Some text";

                    String demp="en";
                     boolean success = GetCacheDirExample.writeAllCachedText(getContext(), "myCacheFile.txt", demp);
                     PackageManager packageManager = getContext().getPackageManager();
                     Intent intent = packageManager.getLaunchIntentForPackage(getContext().getPackageName());
                     ComponentName componentName = intent.getComponent();
                     Intent mainIntent = IntentCompat.makeRestartActivityTask(componentName);
                     Toast.makeText(getContext(), "else", Toast.LENGTH_SHORT).show();
                     getContext().startActivity(mainIntent);

                     System.exit(0);

                     //String readText = GetCacheDirExample.readAllCachedText(this, "myCacheFile.txt");
                     dialog.dismiss();


                 }
             });

             builder.setNegativeButton("French", new DialogInterface.OnClickListener() {

                 @Override
                 public void onClick(DialogInterface dialog, int which) {
                     String textToCache = "Some text";
                     String demp="fr";
                     boolean success = GetCacheDirExample.writeAllCachedText(getContext(), "myCacheFile.txt", demp);
                     //String readText = GetCacheDirExample.readAllCachedText(this, "myCacheFile.txt");
                     PackageManager packageManager = getContext().getPackageManager();
                     Intent intent = packageManager.getLaunchIntentForPackage(getContext().getPackageName());
                     ComponentName componentName = intent.getComponent();
                     Intent mainIntent = IntentCompat.makeRestartActivityTask(componentName);
                     getContext().startActivity(mainIntent);
                     System.exit(0);
                     dialog.dismiss();
                 }
             });
             AlertDialog alert = builder.create();
             alert.show();
         }

     }
     catch (Exception e)
     {    boolean success = GetCacheDirExample.writeAllCachedText(getContext(), "myCacheFile.txt", "x");
         PackageManager packageManager = getContext().getPackageManager();
         Intent intent = packageManager.getLaunchIntentForPackage(getContext().getPackageName());
         ComponentName componentName = intent.getComponent();
         Intent mainIntent = IntentCompat.makeRestartActivityTask(componentName);
         getContext().startActivity(mainIntent);
         System.exit(0);
     }


        super.onViewCreated(view, savedInstanceState);
        getActivity().setTitle("Categories");
        tv1=(TextView)view.findViewById(R.id.cardview_desc);
        tv2=(TextView)view.findViewById(R.id.cardview_title);
        iv1=(ImageView)view.findViewById(R.id.cardviewimg);
        tv3=(TextView)view.findViewById(R.id.cardview_desc2);
        tv4=(TextView)view.findViewById(R.id.cardview_title2);
        iv2=(ImageView)view.findViewById(R.id.cardviewimg2);
        tv5=(TextView)view.findViewById(R.id.cardview_desc3);
        tv6=(TextView)view.findViewById(R.id.cardview_title3);
        iv3=(ImageView)view.findViewById(R.id.cardviewimg3);
        tv7=(TextView)view.findViewById(R.id.cardview_desc4);
        tv8=(TextView)view.findViewById(R.id.cardview_title4);
        iv4=(ImageView)view.findViewById(R.id.cardviewimg4);

        url=url+lang+ GetCacheDirExample.readAllCachedText(getContext(), "myCacheFile.txt");

        StringRequest request=new StringRequest(url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response)
            {
                try
                {
                    if(response!=null)
                    {
                        Log.d("Ja rja haon","GAYA");
                        JSONArray jsonArray = new JSONArray(response);
                        for(int i=0;i<jsonArray.length();i++)
                        {

                            JSONObject jsonObject = jsonArray.getJSONObject(i);
                            t1 = jsonObject.getString("category_id");
                            t2 = jsonObject.getString("name");
                            t3 = jsonObject.getString("image");
                            t4 = jsonObject.getString("description");
                           // Toast.makeText(getActivity(), ""+t3, Toast.LENGTH_SHORT).show();
                            String x=imgcategory+t3;
                            a[i]=t1;
                          //  Toast.makeText(getActivity(), ""+t1, Toast.LENGTH_SHORT).show();
                            if(i==0)
                            {
                                tv1.setText(t4);
                                tv2.setText(t2);
                                Glide.with(iv1.getContext()).load(x).into(iv1);
                            }
                            else if(i==1)
                            {
                                tv3.setText(t4);
                                tv4.setText(t2);
                                Glide.with(iv2.getContext()).load(x).into(iv2);
                            }
                            else if(i==2)
                            {
                                tv5.setText(t4);
                                tv6.setText(t2);
                                Glide.with(iv3.getContext()).load(x).into(iv3);
                            }
                            else if(i==3)
                            {

                                tv7.setText(t4);
                                tv8.setText(t2);
                                Glide.with(iv4.getContext()).load(x).into(iv4);
                            }



                        }


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
        RequestQueue rq= Volley.newRequestQueue(getActivity().getApplicationContext());
        rq.add(request);
        RelativeLayout relative1 = (RelativeLayout)view.findViewById(R.id.rl1);
        relative1.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                Intent intent = new Intent(getActivity(), testing.class);
                intent.putExtra("key",a[0]);
                startActivity(intent);
            }
        });

        RelativeLayout relative2 = (RelativeLayout) view.findViewById(R.id.rl2);
        relative2.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                Intent intent = new Intent(getActivity(), testing.class);
                intent.putExtra("key",a[1]);
                startActivity(intent);
            }
        });
        RelativeLayout relative3 = (RelativeLayout) view.findViewById(R.id.rl3);
        relative3.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                Intent intent = new Intent(getActivity(), testing.class);
                intent.putExtra("key",a[2]);
                startActivity(intent);

            }
        });
        RelativeLayout relative4 = (RelativeLayout) view.findViewById(R.id.rl4);
        relative4.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                Intent intent = new Intent(getActivity(), testing.class);
                intent.putExtra("key",a[3]);
                startActivity(intent);
            }
        });


    }


    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState)
    {
        return inflater.inflate(R.layout.menu1,container,false);

    }



}
