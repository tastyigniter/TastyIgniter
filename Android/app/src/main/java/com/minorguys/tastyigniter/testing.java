package com.minorguys.tastyigniter;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

public class testing extends AppCompatActivity
{
	String server=getResources().getString(R.string.server_url);
    String url = server+"/api/item.php?category=";
int k=0;
    public static Mydata users[];

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_testing);

       Intent intent=getIntent();
        Bundle bundle= intent.getExtras();
        if(bundle!=null)
        {
            String x;
            x=bundle.getString("key");
            url=url+x;

        }
        url=url+"&lang="+GetCacheDirExample.readAllCachedText(this, "myCacheFile.txt");
        final RecyclerView userlist=(RecyclerView)findViewById(R.id.user_list);
        userlist.setLayoutManager(new LinearLayoutManager(this));
        StringRequest request=new StringRequest(url, new com.android.volley.Response.Listener<String>()
        {
            @Override
            public void onResponse(String response)
            {
                Log.d("code",response);

                GsonBuilder gsonBuilder = new GsonBuilder();
                Gson gson = gsonBuilder.create();
                 users = gson.fromJson(response, Mydata[].class);
                Myadapter myadapter=new Myadapter(testing.this,users);
                userlist.setAdapter(myadapter);
                myadapter.notifyDataSetChanged();

            }
        }, new com.android.volley.Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error)
            {
                Log.d("Wronf","Something got wrond");
            }
        });
        RequestQueue rq= Volley.newRequestQueue(this);
        rq.add(request);
    }


}
