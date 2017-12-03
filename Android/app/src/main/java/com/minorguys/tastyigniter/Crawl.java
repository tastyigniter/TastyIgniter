package com.minorguys.tastyigniter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.ImageView;
import android.widget.Toast;

import com.minorguys.tastyigniter.R;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;

/**
 * Created by arpit on 28/9/17.
 */

public class Crawl extends AsyncTask<Object,Object,Void>
{
    String data="";
    String dataparsed="";
    String singleparsed="";
    String names="";
    String desc="";
    int i=0;
    ImageView im;
    // Bitmap bitmap;
    String src1="";

    public Crawl() {
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected void onPostExecute(Void aVoid)
    {

        super.onPostExecute(aVoid);
    }

    @Override
    protected void onProgressUpdate(Object... values) {
        super.onProgressUpdate(values);
    }

    @Override
    protected Void doInBackground(Object[] objects)
    {

        try
        {
            Log.d("Harshul","here");
            String url="http://food.ndtv.com/food-news";
            Element doc= Jsoup.connect(url).get();
            Elements name=doc.select(".rth_link span");
            names = name.text();
            Log.d("Harshul",names);

        }
        catch (IOException e)
        {
            Log.d("Harshul",e.getMessage());
        }

        return null;
    }
}
