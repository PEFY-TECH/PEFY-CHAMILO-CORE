#!/usr/bin/env python3
"""Read-only Chamilo capability inventory. Evidence of code presence, NOT functionality."""
import argparse, json, pathlib, re, hashlib
ROOT=pathlib.Path(__file__).resolve().parents[2]
CATEGORIES={
 "learning_paths":["public/main/lp","src"],
 "assessments":["public/main/exercise","public/main/gradebook"],
 "course_content":["public/main/course_description","public/main/document"],
 "plugins":["public/plugin"],
 "installer":["public/main/install"],
 "identity":["public/main/auth"],
 "surveys":["public/main/survey"],
 "academic_admin":["public/main/admin"],
}
def scan(root):
    data={"repository":str(root),"categories":{},"dependencies":{},"tests":{},"warnings":[]}
    for category,paths in CATEGORIES.items():
        data["categories"][category]={"candidates":[{"path":p,"exists":(root/p).exists(),"files":sum(1 for x in (root/p).rglob("*") if x.is_file()) if (root/p).is_dir() else 0} for p in paths],"functional_status":"UNVERIFIED"}
    for filename,terms in {"composer.json":["h5p/h5p-core","api-platform/core","doctrine/orm","php"],"package.json":["@tinymce/tinymce-vue","@uppy/core","@fullcalendar/vue3"]}.items():
        path=root/filename
        if not path.exists(): data["warnings"].append(filename+" missing");continue
        raw=path.read_bytes()
        try: obj=json.loads(raw)
        except (ValueError,UnicodeDecodeError): data["warnings"].append(filename+" invalid");continue
        deps={**obj.get("require",{}),**obj.get("dependencies",{})}
        data["dependencies"][filename]={"sha256":hashlib.sha256(raw).hexdigest(),"declared":{t:deps.get(t) for t in terms}}
        if filename=="package.json":
            data["tests"]={k:v for k,v in obj.get("scripts",{}).items() if "test:playwright" in k}
    data["warnings"].append("Source inventory only: no DB, installer, runtime, security or end-to-end qualification.")
    return data
if __name__=="__main__":
    p=argparse.ArgumentParser();p.add_argument("--root",default=str(ROOT));p.add_argument("--output");a=p.parse_args()
    report=scan(pathlib.Path(a.root).resolve())
    result=json.dumps(report,ensure_ascii=False,indent=2,sort_keys=True)
    if a.output: pathlib.Path(a.output).write_text(result+"\n",encoding="utf-8")
    else: print(result)
