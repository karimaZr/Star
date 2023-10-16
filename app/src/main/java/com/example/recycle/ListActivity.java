package com.example.recycle;


import static android.service.controls.ControlsProviderService.TAG;
import androidx.appcompat.widget.SearchView;
import androidx.core.view.MenuItemCompat;

import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ShareCompat;

import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;



import com.example.recycle.adapter.StarAdapter;
import com.example.recycle.beans.Star;
import com.example.recycle.services.StarService;

import java.util.ArrayList;
import java.util.List;


public class ListActivity extends AppCompatActivity {
    StarService service = StarService.getInstance();
    private List<Star> stars;
    private RecyclerView recyclerView;
    private StarAdapter starAdapter = null;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list);
        stars = new ArrayList<>();
        service = StarService.getInstance();
        init();
        recyclerView = findViewById(R.id.recycle_View);
        starAdapter = new StarAdapter(this, service.findAll());
        recyclerView.setAdapter(starAdapter);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
    }
    public void init(){
        service.create(new Star("kate bosworth", "https://fr.web.img2.acsta.net/c_310_420/pictures/16/03/01/11/43/442909.jpg", 3.5f));
        service.create(new Star("george clooney", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxJ3j1zaNgXje0dxK0fjSJNsYGRNdR-FwKp0xEwGQu&s", 3));
        service.create(new Star("michelle rodriguez","https://sf1.closermag.fr/wp-content/uploads/closermag/2023/05/michelle-rodriguez-pourquoi-actrice-ete-arretee-2002.jpg", 5));
        service.create(new Star("Selene Gomez", "https://media.admagazine.fr/photos/6482f545c92a9ccbf79f7973/3:2/w_5568,h_3712,c_limit/GettyImages-1244007281.jpg", 3));
        service.create(new Star("louise bouroin", "https://s.yimg.com/ny/api/res/1.2/WF5fNcd.MsOH2OMhwvs_6g--/YXBwaWQ9aGlnaGxhbmRlcjt3PTY0MDtoPTM3Ng--/https://media.zenfs.com/fr/terrafemina_fr_articles_138/f9c556157c2d29e73f48daa4860db31b", 5));
        service.create(new Star("Angelina Jolie", "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMDcdTypkK8HcnMzUZDG4lk3VLe-SFQEOq1A&usqp=CAU", 4));
    }



    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu2, menu);
        MenuItem menuItem = menu.findItem(R.id.app_bar_search);
        SearchView searchView = (SearchView) menuItem.getActionView();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                // Handle text submission here
                return true;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                // Handle text change here (e.g., filtering a list)
                Log.d(TAG, newText);
                return true;
            }
        });
        return true;
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if(item.getItemId() == R.id.share){
            String txt = "Stars";
            String mimeType = "text/plain";
            ShareCompat.IntentBuilder
                    .from(this)
                    .setType(mimeType)
                    .setChooserTitle("Stars")
                    .setText(txt)
                    .startChooser();
        }
        return super.onOptionsItemSelected(item);
    }
}