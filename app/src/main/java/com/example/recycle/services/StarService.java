package com.example.recycle.services;

import com.example.recycle.beans.Star;
import com.example.recycle.idao.IDao;

import java.util.ArrayList;
import java.util.List;

public class StarService implements IDao<Star> {
    private List<Star> stars;
    private static StarService instance;
    private StarService(){
        this.stars=new ArrayList<>();
    }
    public static StarService getInstance(){
        if(instance==null){
            instance=new StarService();
        }
        return instance;
    }
@Override
    public boolean create(Star s){
        return stars.add(s);
    }
    @Override
    public boolean update(Star s){
        for(Star s1:stars) {
            if (s1.getStar() == s.getId()) {
                s1.setImg(s.getImg());
                s1.setName(s.getName());
                s1.setStar(s.getStar());
            }
        }
        return true;
    }
    @Override
    public boolean delete(Star s){
        return stars.remove(s);
    }

    @Override
    public Star findById(int id){
        for(Star s1:stars){
            if(s1.getId()==id)
                return s1;
        }
        return null;
    }
    @Override
    public List<Star> findAll(){
        return stars;
    }

}
