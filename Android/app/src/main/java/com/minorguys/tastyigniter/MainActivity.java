package com.minorguys.tastyigniter;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.util.ArrayList;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {
    public static final String TAG = "MAMA2";
    String names="";
    Elements name;
    ArrayList<String> list = new ArrayList<String>();

    @Override
    protected void onPostResume() {
        Log.d(TAG, "onPostResume: ");
        super.onPostResume();
    }

    @Override
    protected void onStart() {
        Log.d(TAG, "onStart: ");
        super.onStart();
    }


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        Log.d(TAG, "onCreate: ");
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
       // FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);


        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
       /* drawer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                UserData o=new UserData();
                TextView tt=(TextView)v.findViewById(R.id.guest);
                tt.setText(o.getFname());
            }
        });*/
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        displaySelectedScreen(R.id.nav_category);
      
    }

    @Override
    public void onBackPressed() {
        Log.d(TAG, "onBackPressed: ");
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {

        } else {

        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        Log.d(TAG, "onCreateOptionsMenu: ");
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
    private void displaySelectedScreen(int id)
    {
        Fragment fragment=null;
        switch(id)
        {
            case  R.id.nav_category:
                fragment=new Menu1();
                break;
            case R.id.nav_login:
                fragment=new Menu2();
                break;
            case R.id.nav_signup:
                Log.d(TAG, "displaySelectedScreen: ");
                fragment=new Menu3();

                break;
            case R.id.nav_profile:
                fragment=new Menu4();
                break;
            case R.id.nav_signout:
                UserData o=new UserData();
                if(!o.getstatus())
                    Toast.makeText(this, "You should login to logout", Toast.LENGTH_SHORT).show();
                else {o.setstatus(false);
                Toast.makeText(this, "Logged out Successfully.", Toast.LENGTH_SHORT).show();}
                break;
            case R.id.nav_extras:
              //  Intent intent=new Intent(MainActivity.this,Crawl2.class);
               // startActivity(intent);
            Crawl ob=new Crawl();
                ob.execute();
                break;
            case R.id.c1:
                Intent i=new Intent(MainActivity.this,c1.class);
                startActivity(i);
                break;
            case R.id.c2:
                Intent inte=new Intent(MainActivity.this,c2.class);
                startActivity(inte);
                break;


        }
        if(fragment!=null)
        {
            FragmentTransaction ft=getSupportFragmentManager().beginTransaction();
            ft.replace(R.id.content_main,fragment);
            ft.commit();
        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        displaySelectedScreen(id);
        return true;
    }
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
            Intent i = new Intent(getApplication(),Crawl2.class);
           i.putStringArrayListExtra("Archit",list);
            startActivity(i);
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
                name=doc.select(".rth_link span");
                names = name.text();
                Log.d("Harshul",""+name.size());
                for (Element it : name)
                {

                    list.add(it.toString());
                }

            }
            catch (IOException e)
            {
                Log.d("Harshul",e.getMessage());
            }

            return null;
        }
    }
public void gotocart(View v)
{
    Intent i=new Intent(this,check.class);
    startActivity(i);
}
}
