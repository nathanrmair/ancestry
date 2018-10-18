/**
 * Created by gwb13184 on 15/08/2016.
 */

/* include this <script type="text/javascript" src="//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js"></script>
 * as well as thi file
 *
 * pdf formatting classes for html:
 *  > pdf-ignore:   ignores html tag
 *
 *
 */

//create pdf
/**
 * 
 * @param input array of jquery identifiers
 * @param display boolean value for pdf being displayed in the browser (optional: default false)
 * @param save boolean value for pdf save to downloads (optional: default true)
 *
 * takes in an array of jquery formatted identifiers (e.g. #id, .class, tag) and converts them into a pdf document
 */
function createPDF(input, display = false, save = true) {

    //img = canvas.toDataURL("image/png"),
    var doc = new jsPDF({
        unit: 'px',
        format: 'a4'
    });
    doc.setProperties({
        title: 'Title',
        subject: 'This is the subject',
        author: 'MyAncestralScotland',
        keywords: 'generated',
        creator: 'MyAncestralScotland report generator'
    });

    const defaultFontSize = 20,
        margin = 20,
        vMargin = 20,
        lineSpace = 1,
        pageWidth = 360,
        lengthOfPage = 620;

    var size = defaultFontSize,
        offset = vMargin;

    doc.setFontSize(defaultFontSize);//redundant?

    var i;
    for (i = 0; i < input.length; i++) {
        parse(input[i]);

    }
    console.log(offset);

    if (display) {
        doc.output('datauri');
    }
    if (save) {
        doc.save('report.pdf');
    }

    //end

    function parse(data) {
        var e = $(data);

        if (e.hasClass('pdf-ignore')) {
            return;
        }
        //check for class selector
        var eIndex;
        if (e.length > 1) {
            eIndex = 0;
            for (eIndex = 0; eIndex < e.length; eIndex++) {
                parse(e[eIndex]);

            }
            return;
        }

        //check for sub-containers
        var eChildren = e.children();
        if (eChildren.length > 0) {
            eIndex = 0;
            for (eIndex = 0; eIndex < eChildren.length; eIndex++) {
                parse(eChildren[eIndex]);

            }
            return;
        }

        if (e) {
            //jquery selector
            switch (e.prop("tagName")) {

                case 'P':
                    addText(e);
                    break;

                case 'DIV':
                    addText(e);
                    break;

                case 'H1':
                    offset += Math.abs(lineSpace * getFontSize(e));
                    addText(e);
                    break;

                case 'H2':
                    offset += Math.abs(lineSpace * getFontSize(e));
                    addText(e);
                    break;

                case 'H3':
                    offset += Math.abs(lineSpace * getFontSize(e));
                    addText(e);
                    break;

                case 'BR':
                    doc.text((margin + 20), offset, "");
                    offset += size;
                    break;

                case 'CANVAS':

                    // var width = e[0].width;
                    var height = e[0].height;

                    var img = e[0].toDataURL("image/jpeg");
                    // // // // // // // // // // // // //
                    // console.log('URL is: '+img);
                    // checkPageBounds(20);//font size
                    // doc.text((margin + 20), offset,doc.splitTextToSize(('URL is: '+img), lengthOfPage));
                    // offset += lineSpace;
                    // // // // // // // // // // // // //
                    checkPageBounds(height);
                    doc.addImage(img, 'JPEG', margin, offset);
                    offset += (height);
                    offset += (lineSpace);
                    break;

                case 'IMG':
                    // var width = e[0].width;
                    var height = e[0].height;

                    var img = e[0].toDataURL('image/jpeg', 1.0);
                    ;
                    checkPageBounds(height);
                    doc.addImage(img, 'jpeg', margin, offset);
                    offset += (height);
                    offset += (lineSpace);
                    break;

                default:
                    break;
            }

        }
        else {
            //element is not recognised

        }
    }

    function checkPageBounds(height) {
        if ((offset + height) > lengthOfPage) {
            addPage();
        }
    }

    function addText(e) {
        var color = getColor(e, 'color')
        doc.setTextColor(color.red, color.green, color.blue);
        size = getFontSize(e);
        checkPageBounds(size);//font size
        doc.setFontSize(size);
        //var colorString = '('+color.red + ":"+color.green+":"+color.blue+')';
        doc.text((margin + 20), offset, doc.splitTextToSize(e.html(), pageWidth));
        offset += size;
    }

    function addPage() {
        doc.addPage();
        offset = vMargin;
    }

    function getFontSize(e) {
        return parseInt(e.css("font-size").substr(0, (e.css("font-size").length - 2)));
    }

}

function getColor(e, colorType) {
    var arr = e.css(colorType).split(',');
    return colorArr = {
        red: arr[0].trim().substr(4),
        green: arr[1].trim(),
        blue: arr[2].substring(1, (arr[2].lastIndexOf(")")))
    };
}