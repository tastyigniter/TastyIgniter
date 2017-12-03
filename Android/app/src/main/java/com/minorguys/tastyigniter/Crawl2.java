package com.minorguys.tastyigniter;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.ListView;
import android.widget.RadioGroup;
import android.widget.TextView;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;

public class Crawl2 extends AppCompatActivity {
    RadioGroup radioGroup;
    TextView radiotv;
    ArrayList<polling_question> questionArraylist = new ArrayList<>();

    private DatabaseReference mDatabase;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_crawl2);

        mDatabase = FirebaseDatabase.getInstance().getReference();
        Log.d("MAMA", "onCreate:MDatabase "+mDatabase);
        mDatabase.child("Polling").addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {

                for (DataSnapshot QUESTIONS : dataSnapshot.getChildren()) {

                    Log.d("MAMA", "onDataChange: "+dataSnapshot.toString());

                    DataSnapshot OPTIONS = QUESTIONS.child("Option");
                  //  Log.d("MAMA", "ChildPrnting: "+QUESTIONS.child("Question").getValue(String.class));

                    polling_question polling_question = new polling_question();

                    polling_question.setRd1(OPTIONS.child("A").getValue(String.class));
                    polling_question.setRd2(OPTIONS.child("B").getValue(String.class));
                    polling_question.setRd3(OPTIONS.child("C").getValue(String.class));
                    polling_question.setRd4(OPTIONS.child("D").getValue(String.class));

                    polling_question.setQuestion(QUESTIONS.child("Question").getValue(String.class));
 //                   Log.d("MAMA", "PollingQuestion: "+polling_question.getRd2());
                    questionArraylist.add(polling_question);
 //                   Log.d("MAMA", "Check 0th Element "+questionArraylist.get(0).getQuestion());
                    try {
                        Log.d("MAMA", "About to set Adapter: "+questionArraylist.size());
                        polling_adapter polling_adapter = new polling_adapter(getApplicationContext(), questionArraylist);
                        ListView polling_lv = (ListView) findViewById(R.id.polling_lv);

                        polling_lv.setAdapter(polling_adapter);

                    } catch (Exception e) {
                        e.printStackTrace();
                        Log.d("MAMA", "Exception "+e);
                    }
                }
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                Log.d("MAMA", "onCancelledDatabaseError: " + databaseError);
            }
        });

    }
}