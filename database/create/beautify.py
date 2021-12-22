from bs4 import BeautifulSoup # BeautifulSoup is in bs4 package 

code = """        <math>
            <mrow>
                <mrow>
                    <msup>
                        <mi>x</mi>
                        <mn>2</mn>
                    </msup>
                    <mo>+</mo>
                    <msup>
                        <mi>y</mi>
                        <mn>2</mn>
                    </msup>
                </mrow>
                <mo>=</mo>
                <msup>
                    <mi>z</mi>
                    <mn>2</mn>
                </msup>
            </mrow>
        </math>""";
soup = BeautifulSoup(code, features="lxml")
code = soup.prettify()
print(repr(code))